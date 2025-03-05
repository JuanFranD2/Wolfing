<?php

namespace App\Http\Controllers;

use App\Http\Requests\ModifyFeeRequest;
use App\Http\Requests\StoreNewExtraordinaryFeeRequest;
use App\Mail\FeeInvoiceMail;
use App\Models\Fee;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

/**
 * @OA\Tag(
 * name="Fees",
 * description="Operaciones relacionadas con cuotas y facturas."
 * )
 */
class FeeController extends Controller
{
    /**
     * @OA\Get(
     * path="/fees",
     * summary="Lista todas las cuotas",
     * tags={"Fees"},
     * @OA\Parameter(
     * name="search",
     * in="query",
     * description="Buscar cuotas por nombre de cliente.",
     * @OA\Schema(type="string")
     * ),
     * @OA\Response(
     * response=200,
     * description="Lista de cuotas.",
     * @OA\JsonContent(
     * type="array",
     * @OA\Items(ref="#/components/schemas/Fee")
     * )
     * )
     * )
     */
    public function index(Request $request)
    {
        $query = Fee::query()->with('client'); // Cargar la relación 'client'

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->whereHas('client', function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%');
            });
        }

        $fees = $query->paginate(5);

        return view('fees.showFees', compact('fees'));
    }
    /**
     * @OA\Get(
     * path="/fees/create-extraordinary",
     * summary="Muestra el formulario para crear una nueva cuota extraordinaria",
     * tags={"Fees"},
     * @OA\Response(
     * response=200,
     * description="Formulario de creación de cuota extraordinaria."
     * )
     * )
     */
    public function createExtraordinary()
    {
        return view('fees.newExtraordinaryFee');  // Vista para New Extraordinary Fee
    }

    /**
     * @OA\Post(
     * path="/fees",
     * summary="Almacena una nueva cuota extraordinaria",
     * tags={"Fees"},
     * @OA\RequestBody(
     * required=true,
     * @OA\JsonContent(ref="#/components/schemas/StoreNewExtraordinaryFeeRequest")
     * ),
     * @OA\Response(
     * response=302,
     * description="Redirecciona a la lista de cuotas con mensaje de éxito."
     * )
     * )
     */
    public function store(StoreNewExtraordinaryFeeRequest $request)
    {
        // Crear la cuota extraordinaria
        $fee = Fee::create([
            'cif' => $request->cif,
            'concept' => $request->concept,
            'amount' => $request->amount,
            'issue_date' => now()->format('Y-m-d'), // Fecha actual por defecto
            'passed' => 'N',  // Establecer como "No pagada"
            'payment_date' => null, // No se ha pagado aún
            'notes' => $request->notes,
        ]);

        // Encontrar el cliente por CIF y asegurarse de que esté relacionado
        $this->sendFeeInvoice($fee);

        return redirect()->route('fees.index')->with('success', 'Extraordinary fee created successfully.');
    }

    /**
     * @OA\Post(
     * path="/fees/{id}/send-invoice",
     * summary="Envía la factura de una cuota por correo electrónico",
     * tags={"Fees"},
     * @OA\Parameter(
     * name="id",
     * in="path",
     * required=true,
     * description="ID de la cuota.",
     * @OA\Schema(type="integer")
     * ),
     * @OA\Response(
     * response=200,
     * description="Factura enviada correctamente."
     * )
     * )
     */
    public function sendFeeInvoice(Fee $fee)
    {
        $client = $fee->client; // Obtener cliente de la fee
        $pdf = Pdf::loadView('fees.invoice', compact('fee'))->setPaper('a4', 'portrait');

        $pdfPath = 'fee_invoices/invoice_' . $fee->id . '.pdf';

        // Guardar el PDF en el almacenamiento público
        Storage::disk('public')->put($pdfPath, $pdf->output());

        // Ruta al archivo PDF guardado
        $pathToFile = storage_path('app/public/' . $pdfPath);

        // Enviar el correo con el PDF adjunto
        Mail::to($client->email)->send(new FeeInvoiceMail($fee, $pathToFile));

        return response()->json(['message' => 'Invoice sent successfully'], 200);
    }

    /**
     * @OA\Get(
     * path="/fees/{id}",
     * summary="Muestra los detalles de una cuota",
     * tags={"Fees"},
     * @OA\Parameter(
     * name="id",
     * in="path",
     * required=true,
     * description="ID de la cuota.",
     * @OA\Schema(type="integer")
     * ),
     * @OA\Response(
     * response=200,
     * description="Detalles de la cuota.",
     * @OA\JsonContent(ref="#/components/schemas/Fee")
     * )
     * )
     */
    public function show($id)
    {
        // Obtener la cuota por su ID
        $fee = Fee::with('client')->findOrFail($id); // Asegúrate de que Fee tiene una relación con Client

        // Pasar la cuota a la vista showFeeByID
        return view('fees.showFeeByCIF', compact('fee'));
    }

    /**
     * @OA\Get(
     * path="/fees/{id}/edit",
     * summary="Muestra el formulario para editar una cuota",
     * tags={"Fees"},
     * @OA\Parameter(
     * name="id",
     * in="path",
     * required=true,
     * description="ID de la cuota a editar.",
     * @OA\Schema(type="integer")
     * ),
     * @OA\Response(
     * response=200,
     * description="Formulario de edición de cuota."
     * )
     * )
     */
    public function edit($id)
    {
        // Obtener la cuota correspondiente por ID
        $fee = Fee::findOrFail($id);

        // Pasar la cuota a la vista para editarla
        return view('fees.modifyFee', compact('fee'));
    }

    /**
     * Update the specified fee in storage.
     *
     * This method validates the request data, updates the fee, and regenerates its invoice.
     *
     * @param  \App\Http\Requests\ModifyFeeRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ModifyFeeRequest $request, $id)
    {
        // Validación ya aplicada por el ModifyFeeRequest

        // Encontrar la cuota por ID
        $fee = Fee::findOrFail($id);

        // Obtener la ruta del archivo PDF actual y eliminarlo
        $oldPdfPath = storage_path('app/public/fee_invoices/invoice_' . $fee->id . '.pdf');
        if (file_exists($oldPdfPath)) {
            unlink($oldPdfPath); // Eliminar el archivo anterior
        }

        // Actualizar la cuota con los nuevos datos
        $fee->update([
            'cif' => $request->cif,
            'concept' => $request->concept,
            'amount' => $request->amount,
            'notes' => $request->notes,
        ]);

        $fee->load('client');

        // Generar un nuevo PDF con los datos actualizados
        $this->sendFeeInvoice($fee);

        // Redirigir con un mensaje de éxito
        return redirect()->route('fees.index')->with('success', 'Fee updated successfully.');
    }

    /**
     * @OA\Delete(
     * path="/fees/{id}",
     * summary="Elimina una cuota",
     * tags={"Fees"},
     * @OA\Parameter(
     * name="id",
     * in="path",
     * required=true,
     * description="ID de la cuota a eliminar.",
     * @OA\Schema(type="integer")
     * ),
     * @OA\Response(
     * response=302,
     * description="Redirecciona a la lista de cuotas con mensaje de éxito."
     * )
     * )
     */

    public function destroy(string $id)
    {
        // Buscar la cuota (fee) por su ID
        $fee = Fee::findOrFail($id);

        // Eliminar la cuota
        $fee->delete();

        // Redirigir de vuelta con un mensaje de éxito
        return redirect()->route('fees.index')->with('success', 'Fee deleted successfully.');
    }
}

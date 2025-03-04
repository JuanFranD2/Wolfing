<?php

namespace App\Http\Controllers;

use App\Http\Requests\ModifyFeeRequest;
use App\Http\Requests\StoreNewExtraordinaryFeeRequest;
use App\Mail\FeeInvoiceMail;
use App\Models\Fee;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

/**
 * Controller for managing fees and generating invoices.
 */
class FeeController extends Controller
{
    /**
     * Display a listing of the fees.
     *
     * This method retrieves and paginates all fees, showing them in the view.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Obtener todas las cuotas, paginadas de 5 en 5
        $fees = Fee::latest()->paginate(5);

        // Retornar la vista con las cuotas
        return view('fees.showFees', compact('fees'));
    }

    /**
     * Show the form for creating a new extraordinary fee.
     *
     * This method returns the view to create an extraordinary fee.
     *
     * @return \Illuminate\View\View
     */
    public function createExtraordinary()
    {
        return view('fees.newExtraordinaryFee');  // Vista para New Extraordinary Fee
    }

    /**
     * Store a newly created extraordinary fee in storage.
     *
     * This method validates the request data and stores the extraordinary fee.
     * It then generates and sends an invoice for the created fee.
     *
     * @param  \App\Http\Requests\StoreNewExtraordinaryFeeRequest  $request
     * @return \Illuminate\Http\RedirectResponse
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
     * Send the generated fee invoice to the client via email.
     *
     * This method generates a PDF invoice for the fee and sends it to the client's email.
     *
     * @param  \App\Models\Fee  $fee
     * @return \Illuminate\Http\JsonResponse
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
     * Display the details of a specific fee.
     *
     * This method retrieves a fee by its ID and passes it to the view for display.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        // Obtener la cuota por su ID
        $fee = Fee::with('client')->findOrFail($id); // Asegúrate de que Fee tiene una relación con Client

        // Pasar la cuota a la vista showFeeByID
        return view('fees.showFeeByCIF', compact('fee'));
    }

    /**
     * Show the form for editing the specified fee.
     *
     * This method retrieves a fee by its ID and passes it to the view for editing.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
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

        // Generar un nuevo PDF con los datos actualizados
        $this->sendFeeInvoice($fee);

        // Redirigir con un mensaje de éxito
        return redirect()->route('fees.index')->with('success', 'Fee updated successfully.');
    }

    /**
     * Remove the specified fee from storage.
     *
     * This method deletes the specified fee from the database and returns a success message.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
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

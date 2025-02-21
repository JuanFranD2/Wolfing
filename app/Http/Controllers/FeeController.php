<?php

namespace App\Http\Controllers;

use App\Http\Requests\ModifyFeeRequest;
use App\Http\Requests\StoreNewExtraordinaryFeeRequest;
use App\Mail\FeeInvoiceMail;
use App\Models\Fee;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class FeeController extends Controller
{
    /**
     * Display a listing of the fees.
     */
    public function index()
    {
        // Obtener todas las cuotas, paginadas de 5 en 5
        $fees = Fee::latest()->paginate(5);

        // Retornar la vista con las cuotas
        return view('fees.showFees', compact('fees'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function createExtraordinary()
    {
        return view('fees.newExtraordinaryFee');  // Vista para New Extraordinary Fee
    }

    /**
     * Store a newly created resource in storage.
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

    public function sendFeeInvoice($fee)
    {
        // Obtener el cliente relacionado con la cuota
        $client = $fee->client;

        // Generar el PDF a partir de una vista
        $pdf = Pdf::loadView('fees.invoice', compact('fee'));

        // Definir la ruta del archivo PDF usando almacenamiento de Laravel
        $pdfPath = 'fee_invoices/invoice_' . $fee->id . '.pdf';

        // Guardar el PDF en el almacenamiento público
        Storage::disk('public')->put($pdfPath, $pdf->output());

        // Enviar el correo con el PDF adjunto directamente
        Mail::to($client->email)->send(new FeeInvoiceMail($pdf->output()));

        // Eliminar el archivo PDF después de enviarlo (opcional, descomentar si quieres eliminarlo)
        // Storage::disk('public')->delete($pdfPath);

        // Devolver true si todo salió bien
        return true;
    }


    /**
     * Display the details of a specific fee.
     */
    public function show($id)
    {
        // Obtener la cuota por su ID
        $fee = Fee::with('client')->findOrFail($id); // Asegúrate de que Fee tiene una relación con Client

        // Pasar la cuota a la vista showFeeByID
        return view('fees.showFeeByCIF', compact('fee'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Obtener la cuota correspondiente por ID
        $fee = Fee::findOrFail($id);

        // Pasar la cuota a la vista para editarla
        return view('fees.modifyFee', compact('fee'));
    }

    /**
     * Update the specified resource in storage.
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
     * Remove the specified resource from storage.
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

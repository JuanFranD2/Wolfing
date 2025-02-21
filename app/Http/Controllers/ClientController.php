<?php

namespace App\Http\Controllers;

use App\Http\Requests\ModifyClientRequest;
use App\Http\Requests\StoreClientRequest;
use App\Models\Client;
use App\Models\Fee;
use App\Http\Controllers\FeeController;
use App\Mail\FeeInvoiceMail;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class ClientController extends Controller
{
    public function index()
    {
        // Obtener todos los clientes con paginación
        $clients = Client::latest()->paginate(5);
        return view('clients.showClients', compact('clients'));
    }

    public function show($id)
    {
        $client = Client::findOrFail($id);
        return view('clients.showClientByID', compact('client'));
    }

    public function create()
    {
        return view('clients.newClient');
    }

    public function store(StoreClientRequest $request)
    {
        // Crear el cliente con los datos validados
        $client = Client::create($request->validated());

        // Crear una cuota mensual
        $this->createMonthlyFee($client);

        // Redirigir a la lista de clientes con un mensaje de éxito
        return redirect()->route('clients.index')->with('success', 'Client created successfully.');
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
     * Crear una cuota mensual automáticamente cada vez que se crea un cliente.
     */
    private function createMonthlyFee(Client $client)
    {

        $monthName = Carbon::now()->locale('es')->isoFormat('MMMM'); // Obtener el mes en español

        // Definir el concepto y la fecha de emisión
        $concept = 'Mensualidad';
        $issueDate = Carbon::now(); // La fecha en que se crea la cuota (hoy)
        $passed = 'S'; // La cuota se marca como pagada
        $paymentDate = Carbon::now(); // Fecha de pago (la misma que la de creación)
        $notes = 'Mensualidad del mes ' . ucfirst($monthName);  // Nota con el mes en español

        // Crear la cuota mensual
        $fee = Fee::create([
            'cif' => $client->cif,
            'concept' => $concept,
            'issue_date' => $issueDate,
            'amount' => $client->monthly_fee,
            'passed' => $passed,
            'payment_date' => $paymentDate,
            'notes' => $notes
        ]);

        $this->sendFeeInvoice($fee);
    }
    public function edit(Client $client)
    {
        // Pasar el cliente a la vista para poder editarlo
        return view('clients.modifyClient', compact('client'));
    }

    public function update(ModifyClientRequest $request, Client $client)
    {
        // Actualiza el cliente con los datos validados
        $client->update($request->validated());

        return redirect()->route('clients.index')->with('success', 'Client updated successfully.');
    }

    public function destroy($id)
    {
        Client::destroy($id);
        return redirect()->route('clients.index');
    }
}

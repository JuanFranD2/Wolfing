<?php

namespace App\Http\Controllers;

use App\Http\Requests\ModifyClientRequest;
use App\Http\Requests\StoreClientRequest;
use App\Models\Client;
use App\Models\Fee;
use App\Mail\FeeInvoiceMail;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

/**
 * Controller to manage client-related operations.
 */
class ClientController extends Controller
{
    /**
     * Display a listing of the clients.
     *
     * This method retrieves all clients with pagination and displays them.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Obtener todos los clientes con paginación
        $clients = Client::latest()->paginate(5);
        return view('clients.showClients', compact('clients'));
    }

    /**
     * Display the specified client.
     *
     * This method retrieves a client by their ID and displays the details.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $client = Client::findOrFail($id);
        return view('clients.showClientByID', compact('client'));
    }

    /**
     * Show the form to create a new client.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('clients.newClient');
    }

    /**
     * Store a newly created client in the database.
     *
     * This method validates the request data, creates a new client, 
     * generates a monthly fee for the client, and redirects with a success message.
     *
     * @param  \App\Http\Requests\StoreClientRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreClientRequest $request)
    {
        // Crear el cliente con los datos validados
        $client = Client::create($request->validated());

        // Crear una cuota mensual
        $this->createMonthlyFee($client);

        // Redirigir a la lista de clientes con un mensaje de éxito
        return redirect()->route('clients.index')->with('success', 'Client created successfully.');
    }

    /**
     * Send the fee invoice to the client via email.
     *
     * This method generates a PDF invoice for the provided fee and sends it 
     * to the client's email address.
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
     * Create a monthly fee for the client.
     *
     * This method generates a fee for the provided client with specific details 
     * like concept, amount, issue date, and payment date.
     *
     * @param  \App\Models\Client  $client
     * @return void
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

    /**
     * Show the form to edit the specified client.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\View\View
     */
    public function edit(Client $client)
    {
        // Pasar el cliente a la vista para poder editarlo
        return view('clients.modifyClient', compact('client'));
    }

    /**
     * Update the specified client in the database.
     *
     * This method validates the request data and updates the client's information.
     *
     * @param  \App\Http\Requests\ModifyClientRequest  $request
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ModifyClientRequest $request, Client $client)
    {
        // Actualiza el cliente con los datos validados
        $client->update($request->validated());

        return redirect()->route('clients.index')->with('success', 'Client updated successfully.');
    }

    /**
     * Remove the specified client from the database.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        Client::destroy($id);
        return redirect()->route('clients.index');
    }
}

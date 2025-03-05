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
     * @OA\Get(
     * path="/clients",
     * summary="Lista todos los clientes",
     * tags={"Clients"},
     * @OA\Response(
     * response=200,
     * description="Lista de clientes.",
     * @OA\JsonContent(
     * type="array",
     * @OA\Items(ref="#/components/schemas/Client")
     * )
     * )
     * )
     */
    public function index()
    {
        // Obtener todos los clientes con paginación
        $clients = Client::latest()->paginate(5);
        return view('clients.showClients', compact('clients'));
    }

    /**
     * @OA\Get(
     * path="/clients/{id}",
     * summary="Muestra los detalles de un cliente",
     * tags={"Clients"},
     * @OA\Parameter(
     * name="id",
     * in="path",
     * required=true,
     * description="ID del cliente.",
     * @OA\Schema(type="integer")
     * ),
     * @OA\Response(
     * response=200,
     * description="Detalles del cliente.",
     * @OA\JsonContent(ref="#/components/schemas/Client")
     * )
     * )
     */
    public function show($id)
    {
        $client = Client::findOrFail($id);
        return view('clients.showClientByID', compact('client'));
    }

    /**
     * @OA\Get(
     * path="/clients/create",
     * summary="Muestra el formulario para crear un nuevo cliente",
     * tags={"Clients"},
     * @OA\Response(
     * response=200,
     * description="Formulario de creación de cliente."
     * )
     * )
     */
    public function create()
    {
        return view('clients.newClient');
    }

    /**
     * @OA\Post(
     * path="/clients",
     * summary="Almacena un nuevo cliente",
     * tags={"Clients"},
     * @OA\RequestBody(
     * required=true,
     * @OA\JsonContent(ref="#/components/schemas/StoreClientRequest")
     * ),
     * @OA\Response(
     * response=302,
     * description="Redirecciona a la lista de clientes con mensaje de éxito."
     * )
     * )
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
     * @OA\Post(
     * path="/clients/send-invoice/{id}",
     * summary="Envía la factura de una cuota por correo electrónico",
     * tags={"Clients"},
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
     * @OA\Get(
     * path="/clients/{client}/edit",
     * summary="Muestra el formulario para editar un cliente",
     * tags={"Clients"},
     * @OA\Parameter(
     * name="client",
     * in="path",
     * required=true,
     * description="ID del cliente a editar.",
     * @OA\Schema(type="integer")
     * ),
     * @OA\Response(
     * response=200,
     * description="Formulario de edición de cliente."
     * )
     * )
     */
    public function edit(Client $client)
    {
        // Pasar el cliente a la vista para poder editarlo
        return view('clients.modifyClient', compact('client'));
    }

    /**
     * @OA\Put(
     * path="/clients/{client}",
     * summary="Actualiza un cliente existente",
     * tags={"Clients"},
     * @OA\Parameter(
     * name="client",
     * in="path",
     * required=true,
     * description="ID del cliente a actualizar.",
     * @OA\Schema(type="integer")
     * ),
     * @OA\RequestBody(
     * required=true,
     * @OA\JsonContent(ref="#/components/schemas/ModifyClientRequest")
     * ),
     * @OA\Response(
     * response=302,
     * description="Redirecciona a la lista de clientes con mensaje de éxito."
     * )
     * )
     */
    public function update(ModifyClientRequest $request, Client $client)
    {
        // Actualiza el cliente con los datos validados
        $client->update($request->validated());

        return redirect()->route('clients.index')->with('success', 'Client updated successfully.');
    }

    /**
     * @OA\Delete(
     * path="/clients/{id}",
     * summary="Elimina un cliente",
     * tags={"Clients"},
     * @OA\Parameter(
     * name="id",
     * in="path",
     * required=true,
     * description="ID del cliente a eliminar.",
     * @OA\Schema(type="integer")
     * ),
     * @OA\Response(
     * response=302,
     * description="Redirecciona a la lista de clientes."
     * )
     * )
     */
    public function destroy($id)
    {
        Client::destroy($id);
        return redirect()->route('clients.index');
    }
}

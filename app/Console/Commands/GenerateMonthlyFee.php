<?php

namespace App\Console\Commands;

use App\Mail\FeeInvoiceMail;
use Illuminate\Console\Command;
use App\Models\Client;
use App\Models\Fee;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

/**
 * Command for generating monthly fees for all clients and sending invoices.
 */
class GenerateMonthlyFee extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:monthly-fee';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate monthly fees for all clients';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * This method retrieves all clients and generates a monthly fee for each.
     * It is invoked when the command is run.
     *
     * @return void
     */
    public function handle()
    {
        $clients = Client::all(); // Obtener todos los clientes

        foreach ($clients as $client) {
            $this->createMonthlyFee($client); // Crear la cuota mensual para cada cliente
        }

        $this->info('Monthly fees generated successfully.');
    }

    /**
     * Create the monthly fee for a client.
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
     * Send the generated fee invoice to the client via email.
     *
     * This method generates a PDF invoice for the fee and sends it to the
     * client's email address.
     *
     * @param  \App\Models\Fee  $fee
     * @return bool
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
}

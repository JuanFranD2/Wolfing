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

class GenerateMonthlyFee extends Command
{
    protected $signature = 'generate:monthly-fee';
    protected $description = 'Generate monthly fees for all clients';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $clients = Client::all(); // Obtener todos los clientes

        foreach ($clients as $client) {
            $this->createMonthlyFee($client); // Crear la cuota mensual para cada cliente
        }

        $this->info('Monthly fees generated successfully.');
    }

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
}

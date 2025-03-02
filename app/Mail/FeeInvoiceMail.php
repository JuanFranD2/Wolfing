<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Fee; // Importa el modelo Fee
use Illuminate\Support\Facades\Log;

class FeeInvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    public $fee;
    public $pdfPath;

    /**
     * Create a new message instance.
     */
    public function __construct(Fee $fee, $pdfPath)
    {
        if (!$fee) {
            Log::error("Error: \$fee es null en FeeInvoiceMail.");
            throw new \Exception("El parámetro \$fee es null.");
        }

        if (!$fee->client || !$fee->client->email) {
            Log::error("Error: Cliente de la fee no tiene un correo válido.");
            throw new \Exception("El cliente no tiene un correo válido.");
        }

        $this->fee = $fee;
        $this->pdfPath = $pdfPath;
    }
    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Your Fee Invoice - ' . $this->fee->id)
            ->view('emails.fee_invoice')
            ->attach($this->pdfPath, [
                'as' => 'invoice_' . $this->fee->id . '.pdf',
                'mime' => 'application/pdf',
            ]);
    }
}

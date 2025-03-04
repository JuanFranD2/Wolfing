<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Fee; // Importa el modelo Fee
use Illuminate\Support\Facades\Log;

/**
 * Mailable class to send a fee invoice email.
 *
 * This class is responsible for creating the email message with the fee details
 * and attaching the corresponding PDF invoice. It performs basic validation 
 * to ensure the fee and client email are valid.
 */
class FeeInvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    public $fee;
    public $pdfPath;

    /**
     * Create a new message instance.
     *
     * This method initializes the FeeInvoiceMail instance with a given Fee and PDF file path.
     * It checks if the Fee object and its associated client email are valid. If not, it logs an error.
     *
     * @param  \App\Models\Fee  $fee
     * @param  string  $pdfPath
     * @throws \Exception
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
     *
     * This method constructs the email message, sets the subject, the view to render,
     * and attaches the generated PDF invoice to the email. The attachment is named
     * based on the fee ID and is set to the PDF MIME type.
     *
     * @return \Illuminate\Mail\Mailable
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

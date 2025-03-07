<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Fee;
use Illuminate\Support\Facades\Log;

class FeeInvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    public $fee;
    public $pdfPath;
    public $convertedAmount;
    public $currency;

    /**
     * Create a new message instance.
     *
     * @param  \App\Models\Fee  $fee
     * @param  string  $pdfPath
     * @param  float  $convertedAmount
     * @param  string  $currency
     * @throws \Exception
     */
    public function __construct(Fee $fee, $pdfPath, $convertedAmount = null, $currency = 'EUR')
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
        $this->convertedAmount = $convertedAmount;
        $this->currency = $currency;
    }

    /**
     * Build the message.
     *
     * @return \Illuminate\Mail\Mailable
     */
    public function build()
    {
        return $this->subject('Your Fee Invoice - ' . $this->fee->id)
            ->view('emails.fee_invoice')
            ->with([
                'convertedAmount' => $this->convertedAmount,
                'currency' => $this->currency
            ])
            ->attach($this->pdfPath, [
                'as' => 'invoice_' . $this->fee->id . '.pdf',
                'mime' => 'application/pdf',
            ]);
    }
}

<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FeeInvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    public $pdfContent;

    // Recibimos el contenido del PDF en lugar del path
    public function __construct($pdfContent)
    {
        $this->pdfContent = $pdfContent;
    }

    public function build()
    {
        return $this->view('emails.fee_invoice')  // Vista del correo
            ->subject('Your Fee Invoice')   // Asunto del correo
            ->attachData($this->pdfContent, 'invoice.pdf', [ // Usamos attachData para enviar el contenido directamente
                'mime' => 'application/pdf',
            ]);
    }
}

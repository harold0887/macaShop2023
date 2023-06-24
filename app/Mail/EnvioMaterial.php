<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EnvioMaterial extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $message;
    public $name;
    public $subject;
    public $format;
    public $articles;
    public $document;
    public $folio;
    public function __construct($product)
    {
        $this->subject = $product->title;
        $this->name = $product->name;
        $this->format = $product->format;
        $this->document = $product->document;
        $this->folio = $product->folio;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        //enviar PDF con folio
        if ($this->format == 'pdf' && $this->folio == true) {

            return $this->markdown('email.resend')
                ->attach('./pdf/newpdf.pdf', [
                    'as' => $this->name,
                    'mime' => 'application/pdf',    
                ]);
        } else {

            //enviar power point o pdf sin folio
            return $this->markdown('email.resend')
                ->attach('storage/' . $this->document, [
                    'as' => $this->name,
                ]);
        }
    }
}

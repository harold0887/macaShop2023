<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentApprovedEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $message;
    public $name;
    public $subject;
    public $format;
    public $articles;
    public $document;
    public $order;
    public $url;


    public function __construct($order, $name)
    {
        $this->subject = 'Confirmación de Compra ' . $order;
        $this->name = $name;
        $this->order = $order;
        $this->url = "https://materialdidacticomaca.com/";
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('email.order-success');
    }
}

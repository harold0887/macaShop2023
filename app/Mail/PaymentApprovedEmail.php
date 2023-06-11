<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

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
    public $price;



    public function __construct($order, $name, $price)
    {
        $this->subject = 'Confirmación de compra ' . $order;
        $this->name = $name;
        $this->order = $order;
        $this->url = "https://materialdidacticomaca.com/";
        $this->price= $price;
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

<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class MembresiaPreescolar extends Mailable
{
   
    public $name;
    public $subject;
    public $order;
    public $url;
    public $email;
    public $title;
    public $price;
    use Queueable, SerializesModels;

  
    public function __construct($order, $name, $price)
    {
        $this->subject="Confirmación de compra membresía Preescolar VIP";
        $this->name = $name;
        $this->order = $order;
        $this->title="MEMBRESÍA PREESCOLAR 2023-2024";
        $this->price= $price;
        $this->email=Auth::user()->email;
        $this->url="https://api.whatsapp.com/send?phone=+9981838908&text=Quiero%20activar%20mi%20membres%C3%ADa%20PREESCOLAR%20-%20compra%20web: ".$order." - ".$this->email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('email.membresia-preescolar');
    }
}

<?php

namespace App\Mail;

use App\Models\Order;
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
    public $order;
    public $url;
    public $price;
    public $date;



    public function __construct(Order $order)
    {
        $this->subject = 'Confirmación de compra ' . $order->id;
        $this->name = $order->user->name;
        $this->order = $order->id;
        $this->url = "https://materialdidacticomaca.com/";
        $this->price= $order->amount;
        $this->date= $order->created_at;
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

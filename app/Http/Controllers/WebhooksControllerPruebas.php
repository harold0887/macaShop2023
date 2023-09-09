<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\PaymentApprovedEmail;
use Illuminate\Support\Facades\Mail;

class WebhooksControllerPruebas extends Controller
{
    public function __invoke(Request $request)
    {
        $idMP = $request["data"]["id"]; //obtener el id de Mercado Pago

        $notificacion = new PaymentApprovedEmail($idMP, "arnold", 500);
        Mail::to('arnulfoacosta0887@gmail.com') //copia, dupliacar con correo de cliente
            ->send($notificacion);
    }
}

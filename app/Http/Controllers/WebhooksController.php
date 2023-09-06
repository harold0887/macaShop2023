<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\PaymentApprovedEmail;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class WebhooksController extends Controller
{
    public function __invoke(Request $request)
    {
        $idMP = $request["data"]["id"]; //obtener el id de Mercado Pago

        //obtener el pago completo en json
        $response = Http::get("https://api.mercadopago.com/v1/payments/$idMP" . "?access_token=APP_USR-2311547743825741-013023-3721797a3fbdf97bf2d4ff3f58000481-269113557");

        $response = json_decode($response);

        $order = Order::findOrFail($response->external_reference);




        //Actualizar status de orden
        $order->update([
            'status' => $response->status,
            'payment_id' => $response->id,
            'payment_type' => $response->payment_type_id,
        ]);




        switch ($response->status) {
            case 'approved':
                $notificacion = new PaymentApprovedEmail($order->id, $order->user->name, $order->amount . '-approved');
                Mail::to('arnulfoacosta0887@gmail.com')
                    ->send($notificacion);
                break;
            case 'pending':
                $notificacion = new PaymentApprovedEmail($order->id, $order->user->name, $order->amount . '-pending');
                Mail::to('arnulfoacosta0887@gmail.com')
                    ->send($notificacion);
                break;
            case 'in_process':

                break;
            case 'failure':

                break;
            default:

                break;
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\Order_Details;
use App\Mail\MembresiaPrimaria;
use App\Mail\MembresiaPreescolar;
use App\Mail\PaymentApprovedEmail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class WebhooksController extends Controller
{
    public function __invoke(Request $request)
    {
        $idMP = $request["data"]["id"]; //obtener el id de Mercado Pago

        //obtener el pago completo en json
        $response = Http::get("https://api.mercadopago.com/v1/payments/$idMP" . "?access_token=APP_USR-1396168196491507-110321-568e292721694b54f54b81b846887014-787241098");



        $response = json_decode($response);

        $order = Order::findOrFail($response->external_reference);




        //Actualizar status de orden
        $order->update([
            'status' => $response->status,
            'payment_id' => $response->id,
            'payment_type' => $response->payment_type_id,
        ]);


        //Esto es nuevo
        $products = Order_Details::where('order_id', $order->id)->where('product_id', '!=', null)->get();
        $packages = Order_Details::where('order_id', $order->id)->where('package_id', '!=', null)->get();
        $membreships = Order_Details::where('order_id', $order->id)->where('membership_id', '!=', null)->get();
        $materialesComprados = false; //iniciar en falso, por que no sabemos que inlcuye la orden



        //Si incluye productos o paquetes, se cambia a true para enviar email de compra
        if ($products->count() > 0 || $packages->count() > 0) {
            $materialesComprados = true;
        }



        switch ($response->status) {
            case 'approved':

                //enviar correo de materiales
                if ($materialesComprados) {
                    $notificacion = new PaymentApprovedEmail($order);
                    Mail::to($order->user->email) //enviar correo al cliente
                        ->send($notificacion);
                    // $notificacion = new PaymentApprovedEmail($order);
                    // Mail::to('arnulfoacosta0887@gmail.com') 
                    //     ->send($notificacion);
                }

                //enviar correo de membresias
                foreach ($membreships as $membresia) {

                    //validar si es membresia preescolar, se tiene que cambiar cada año
                    if ($membresia->membership_id == 2006) {

                        $correoCopia = new MembresiaPreescolar($order->id, $order->user->name, $order->user->email, $membresia->price);
                        Mail::to($order->user->email)
                            ->send($correoCopia);

                        // $correoCopia = new MembresiaPreescolar($order->id, $order->user->name, $order->user->email, $membresia->price);
                        // Mail::to('arnulfoacosta0887@gmail.com')
                        //     ->send($correoCopia);
                    }

                    if ($membresia->membership_id  == 2007) {
                        $correoCopia = new MembresiaPrimaria($order->id, $order->user->name, $order->user->email, $membresia->price);
                        Mail::to($order->user->email)
                            ->send($correoCopia);

                        // $correoCopia = new MembresiaPrimaria($order->id, $order->user->name, $order->user->email, $membresia->price);
                        // Mail::to('arnulfoacosta0887@gmail.com')
                        //     ->send($correoCopia);
                    }
                }
                break;
            case 'pending':
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

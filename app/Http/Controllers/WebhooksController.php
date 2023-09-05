<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\PaymentApprovedEmail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class WebhooksController extends Controller
{
    public function __invoke(Request $request)
    {


        $notificacion = new PaymentApprovedEmail(12155, $request->id, 99);
        Mail::to('arnulfoacosta0887@gmail.com')
            ->send($notificacion);


        // $response = Http::get("https://api.mercadopago.com/v1/payments/$id" . "?access_token=APP_USR-2311547743825741-013023-3721797a3fbdf97bf2d4ff3f58000481-269113557");

        // $response = json_decode($response);
        // $newStatus = $response->status;

        // try {
        //     Order::where('payment_id', $id)
        //         ->firstOrFail()
        //         ->update([
        //             'status' => $newStatus,
        //         ]);

        //     $this->emit('success-auto-close', [
        //         'message' => 'El pago se actualizó con éxito',
        //     ]);
        // } catch (QueryException $e) {
        //     $this->emit('error', [
        //         'error' => 'Ocurrio un error al actualizar el pago.',
        //     ]);
        // }


    }
}

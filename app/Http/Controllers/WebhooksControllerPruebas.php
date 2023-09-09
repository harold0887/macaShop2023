<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WebhooksControllerPruebas extends Controller
{
    public function __invoke(Request $request)
    {
        $idMP = $request["data"]["id"]; //obtener el id de Mercado Pago
    }
}

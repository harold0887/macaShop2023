<?php

namespace App\Http\Controllers;

use App\Models\Ip;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Order_Details;
use App\Mail\MembresiaPrimaria;
use App\Mail\MembresiaPreescolar;
use App\Mail\PaymentApprovedEmail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class MainController extends Controller
{
    //envios reales pagina web

    public function thanks_you() //Metodo al que retorna al finalizar la compra real
    {

        //obtener la order
        $order = Order::findOrFail(request('external_reference'));



        switch (request('status')) {
            case 'approved':
                return redirect()->route('order.show', [$order->id])->with('paySuccess', 'El pago ha sido realizado con éxito.');
                break;
            case 'pending':
                return redirect()->route('order.show', [$order->id])->with('payPending', 'El pago está  en proceso de validación.');
                break;
            case 'in_process':
                return redirect()->route('order.show', [$order->id])->with('payInProccess', 'El pago está  en proceso de validación para garantizar la total seguridad de la transacción.');
                break;
            case 'failure':
                return redirect()->route('order.show', [$order->id])->with('error', 'Tu compra no se pudo realizar.');
                break;
            default:
                return redirect()->route('order.show', [$order->id])->with('error', 'Ocurrio un error al procesar tu compra');
                break;
        }
    }























    public function thanks_you5() //Metodo al que retorna al finalizar la compra
    {
        $materialesComprados = false;
        $MembresiasCompradas = [];
        $orderActive = true; //Iniciar la order como active, solo se desactiva si es membresía, paquete o producto con folio

        $newOrder = Order::create([
            'customer_id' => Auth::user()->id,
            'amount' => \Cart::getTotal(),
            'status' => request('status'),
            'payment_type' => request('payment_type'),
            'payment_id' => request('payment_id'),
            'order_id' => request('merchant_order_id')
        ]);

        //return "creo la orden";

        foreach (\Cart::getContent() as $item) {
            if ($item->associatedModel->model == 'Membership') {
                Order_Details::create([
                    'order_id' => $newOrder->id,
                    'membership_id' => $item->id,
                    'price' => $item->price,
                ]);
                $MembresiasCompradas[] = [
                    'membership_id' => $item->id,
                    'title' => $newOrder->title,
                    'price' => $item->price,
                ];
                $orderActive = false;
            } elseif ($item->associatedModel->model == 'Package') {
                Order_Details::create([
                    'order_id' => $newOrder->id,
                    'package_id' => $item->id,
                    'price' => $item->price,
                ]);
                $materialesComprados = true;
                $orderActive = false;
            } elseif ($item->associatedModel->model == 'Product') {
                Order_Details::create([
                    'order_id' => $newOrder->id,
                    'product_id' => $item->id,
                    'price' => $item->price,
                ]);
                $materialesComprados = true;

                if ($item->associatedModel->folio == 1) {
                    $orderActive = false;
                }
            }
        }

        $productosCart = \Cart::getContent();

        $Total = \Cart::getTotal() . ".00";
        $order = $newOrder->id;
        $payment_type = request('payment_type');


        //Actualizar status de orden
        Order::findOrFail($newOrder->id)->update([
            'active' => $orderActive,
        ]);






        \Cart::clear();


        switch (request('status')) {
            case 'approved':

                //enviar correo de materiales
                if ($materialesComprados) {
                    $correo = new PaymentApprovedEmail($newOrder->id, Auth::user()->name, $Total);
                    Mail::to(Auth::user()->email)
                        ->send($correo);

                    $correoCopia = new PaymentApprovedEmail($newOrder->id, Auth::user()->name, $Total);
                    Mail::to('arnulfoacosta0887@gmail.com')
                        ->send($correoCopia);
                }

                //enviar correo de membresias
                foreach ($MembresiasCompradas as $membresia) {

                    //validar si es membresia preescolar, se tiene que cambiar cada año
                    if ($membresia['membership_id'] == 2006) {

                        $correo = new MembresiaPreescolar($newOrder->id, Auth::user()->name, Auth::user()->email, $membresia['price']);
                        Mail::to(Auth::user()->email)
                            ->send($correo);
                        $correoCopia = new MembresiaPreescolar($newOrder->id, Auth::user()->name, Auth::user()->email, $membresia['price']);
                        Mail::to('arnulfoacosta0887@gmail.com')
                            ->send($correoCopia);
                    }

                    if ($membresia['membership_id'] == 2007) {
                        $correo = new MembresiaPrimaria($newOrder->id, Auth::user()->name, Auth::user()->email, $membresia['price']);
                        Mail::to(Auth::user()->email)
                            ->send($correo);
                        $correoCopia = new MembresiaPrimaria($newOrder->id, Auth::user()->name, Auth::user()->email, $membresia['price']);
                        Mail::to('arnulfoacosta0887@gmail.com')
                            ->send($correoCopia);
                    }
                }




                return view('shop.success', compact('productosCart', 'Total', 'order', 'payment_type'));
                break;


                // //enviar email de compra
                // $correo = new PaymentApprovedEmail($newOrder->id, Auth::user()->name);
                // Mail::to(Auth::user()->email)
                //     ->cc('arnulfoacosta0887@gmail.com')
                //     ->send($correo);
                // return view('shop.success', compact('productosCart', 'Total', 'order', 'payment_type'));
                // break;
            case 'pending':
                $correo = new PaymentApprovedEmail($newOrder->id, Auth::user()->name, $Total);
                Mail::to(Auth::user()->email)
                    //->cc('arnulfoacosta0887@gmail.com')
                    ->send($correo);
                return view('shop.pending', compact('productosCart', 'Total', 'order', 'payment_type'));
                break;
            case 'in_process':
                return redirect()->route('customer.orders')->with('in_process', 'Tu compra fue realizada con éxito y esta en proceso de validación para garantizar la total seguridad de la transacción.');
                break;
            case 'failure':

                return redirect()->route('customer.orders')->with('failure', 'Tu compra no se pudo realizar.');
                break;
            default:

                return redirect()->route('customer.orders')->with('failure', 'Ocurrio un error al procesar tu compra');
                break;
        }
    }

    public function thanks_you1() //Metodo al que retorna al finalizar la compra
    {

        $MembresiasCompradas = [];
        $materialesComprados = false;


        $lastOrderAll = Order::take(1)->orderByDesc('id')->select('id')->get();
        $status = "approved";
        $payment_type = "credit_card";
        $payment_id = $lastOrderAll[0]->id++;


        $newOrder = Order::create([
            'customer_id' => Auth::user()->id,
            'amount' => \Cart::getTotal(),
            'status' => $status,
            'payment_type' => $payment_type,
            'payment_id' => $payment_id,
            'order_id' => $payment_id
        ]);







        //return "creo la orden";

        foreach (\Cart::getContent() as $item) {
            if ($item->associatedModel->model == 'Membership') {
                Order_Details::create([
                    'order_id' => $newOrder->id,
                    'membership_id' => $item->id,
                    'price' => $item->price,
                ]);

                $MembresiasCompradas[] = [
                    'membership_id' => $item->id,
                    'title' => $item->name,
                    'price' => $item->price,
                ];
            } elseif ($item->associatedModel->model == 'Package') {
                Order_Details::create([
                    'order_id' => $newOrder->id,
                    'package_id' => $item->id,
                    'price' => $item->price,
                ]);
                $materialesComprados = true;
            } elseif ($item->associatedModel->model == 'Product') {
                Order_Details::create([
                    'order_id' => $newOrder->id,
                    'product_id' => $item->id,
                    'price' => $item->price,
                ]);
                $materialesComprados = true;
            }
        }

        $productosCart = \Cart::getContent();

        $Total = \Cart::getTotal();
        $order = $newOrder->id;
        $payment_type = request('payment_type');






        \Cart::clear();




        switch ($status) {


            case 'approved':

                //enviar correo de materiales
                if ($materialesComprados) {
                    $correo = new PaymentApprovedEmail($newOrder->id, Auth::user()->name, $Total);
                    Mail::to(Auth::user()->email)
                        ->cc('arnulfoacosta0887@gmail.com')
                        ->send($correo);
                }

                //enviar correo de membresias
                //dd($MembresiasCompradas);
                foreach ($MembresiasCompradas as $membresia) {

                    //validar si es membresia preescolar, se tiene que cambiar cada año
                    if ($membresia['membership_id'] == 2006) {



                        $correo = new MembresiaPreescolar($newOrder->id, Auth::user()->name, $membresia['price']);
                        Mail::to(Auth::user()->email)
                            ->cc('arnulfoacosta0887@gmail.com')
                            ->send($correo);
                    }

                    if ($membresia['membership_id'] == 2007) {


                        $correo = new MembresiaPrimaria($newOrder->id, Auth::user()->name, $membresia['price']);
                        Mail::to(Auth::user()->email)
                            ->cc('arnulfoacosta0887@gmail.com')
                            ->send($correo);
                    }
                }






                //enviar email de compra









                return view('shop.success', compact('productosCart', 'Total', 'order', 'payment_type'));
                break;
            case 'pending':
                $correo = new PaymentApprovedEmail($newOrder->id, Auth::user()->name, $Total);
                Mail::to(Auth::user()->email)
                    //->cc('arnulfoacosta0887@gmail.com')
                    ->send($correo);
                return view('shop.pending', compact('productosCart', 'Total', 'order', 'payment_type'));
                break;
            case 'in_process':
                return redirect()->route('customer.orders')->with('in_process', 'Tu compra fue realizada con éxito y esta en proceso de validación para garantizar la total seguridad de la transacción.');
                break;
            case 'failure':

                return redirect()->route('customer.orders')->with('failure', 'Tu compra no se pudo realizar.');
                break;
            default:

                return redirect()->route('customer.orders')->with('failure', 'Ocurrio un error al procesar tu compra');
                break;
        }
    }






    //pruebas para enviar notificacion
    public function thanks_you2() //recepcion de noticias automatica de mercado pago
    {

        $lastOrderAll = Order::take(1)->orderByDesc('id')->select('id')->get();
        $status = "approved";
        $payment_type = "credit_card";
        $payment_id = $lastOrderAll[0]->id++;


        $newOrder = Order::create([
            'customer_id' => Auth::user()->id,
            'amount' => \Cart::getTotal(),
            'status' => $status,
            'payment_type' => $payment_type,
            'payment_id' => $payment_id,
            'order_id' => $payment_id
        ]);

        $lastOrderCustomer = Order::take(1)->orderByDesc('id')->select('id')->get();
        $lastOrderCustomer_id = $lastOrderCustomer[0]->id;


        foreach (\Cart::getContent() as $item) {
            if ($item->associatedModel->model == 'Membership') {
                Order_Details::create([
                    'order_id' => $newOrder->id,
                    'membership_id' => $item->id,
                    'price' => $item->price,
                ]);
            } elseif ($item->associatedModel->model == 'Package') {
                Order_Details::create([
                    'order_id' => $newOrder->id,
                    'package_id' => $item->id,
                    'price' => $item->price,
                ]);
            } elseif ($item->associatedModel->model == 'Product') {
                Order_Details::create([
                    'order_id' => $newOrder->id,
                    'product_id' => $item->id,
                    'price' => $item->price,
                ]);
            }
        }
        $productosCart = \Cart::getContent();

        $Total = \Cart::getTotal();
        $order = $newOrder->id;
        $payment_type = request('payment_type');
        //   \Cart::clear();


        switch ($status) {
            case 'approved':
                //enviar email de compra
                // $correo = new PaymentApprovedEmail($lastOrderCustomer[0]->id, Auth::user()->name);
                // Mail::to(Auth::user()->email)
                //     ->cc('arnulfoacosta0887@gmail.com')
                //     ->send($correo);

                return view('shop.success', compact('productosCart', 'Total', 'order', 'payment_type'));
                //redirect()->route('customer.orders')->with('orderSuccess', 'Tu compra fue realizada con éxito.');
                break;
            case 'pending':
                return view('shop.pending', compact('productosCart', 'Total', 'lastOrderCustomer_id', 'payment_type'));
                //return redirect()->route('customer.orders')->with('pending', 'Tu compra fue realizada con éxito y esta en espera del pago');
                break;
            case 'in_process':
                return redirect()->route('customer.orders')->with('in_process', 'Tu compra fue realizada con éxito y esta en proceso de validación para garantizar la total seguridad de la transacción.');
                break;
            case 'failure':
                return redirect()->route('customer.orders')->with('failure', 'Tu compra no se pudo realizar.');
                break;
            default:
                return redirect()->route('customer.orders')->with('failure', 'Ocurrio un error al procesar tu compra');
                break;
        }
    }







    public function terminos()
    {
        return view('terminos');
    }
    public function aviso()
    {
        return view('aviso');
    }
    public function questions()
    {
        return view('questions');
    }
    public function contact()
    {
        return view('contact');
    }

    public function customerOrders()
    {

       
        $orders = Order::where('customer_id', Auth::user()->id)
            ->orderByDesc('created_at', 'desc')
            ->get();
        return view('account.account-orders', compact('orders'));
    }
    public function customerMemberships(Request $request)
    {
        Ip::create([
            'user_id' => Auth::user()->id,
            'ip' => $request->ip(),
            'tipo' => 'membresias',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        $memberships = Order_Details::join('orders', 'order_details.order_id', '=', 'orders.id')
            ->join('memberships', 'order_details.membership_id', '=', 'memberships.id')
            ->where('orders.customer_id', Auth::user()->id)
            ->where('orders.status', 'approved')
            ->orderByDesc('orders.id')
            ->select(
                'memberships.id as membership_id',
                'orders.id as order_id',
                'memberships.title',
                'memberships.expiration',
                'orders.created_at'
            )
            ->get();
        return view('account.account-memberships', compact('memberships'));
    }


    public function customerPackages()
    {
        $packages = Order_Details::join('orders', 'order_details.order_id', '=', 'orders.id')
            ->join('packages', 'order_details.package_id', '=', 'packages.id')
            ->where('orders.customer_id', Auth::user()->id)
            ->where('orders.status', 'approved')
            ->orderByDesc('orders.id')
            ->select(
                'packages.id as package_id',
                'orders.id as order_id',
                'packages.title',
                'orders.created_at'
            )
            ->get();

        //dd($packages)    ;
        return view('account.account-packages', compact('packages'));
    }

    public function search(Request $request)
    {
        $term = $request->get('term');

        $query = Product::where('name', 'LIKE', '%' . $term . '%')
            ->orderBy('title')
            ->get();

        $data = [];

        foreach ($query as $q) {
            $data[] = [
                'label' => $q->title,
                'value' => $q->slug
            ];
        }

        return $data;
    }



    public function createOrder()
    {

        $orderActive = true; //Iniciar la order como active, solo se desactiva si es membresía, paquete o producto con folio y si ya tiene whatsApp

        $newOrder = Order::create([
            'customer_id' => Auth::user()->id,
            'amount' => \Cart::getTotal(),
            'status' => 'create',

        ]);



        foreach (\Cart::getContent() as $item) {
            if ($item->associatedModel->model == 'Membership') {
                Order_Details::create([
                    'order_id' => $newOrder->id,
                    'membership_id' => $item->id,
                    'price' => $item->price,
                ]);
                $orderActive = false;
            } elseif ($item->associatedModel->model == 'Package') {
                Order_Details::create([
                    'order_id' => $newOrder->id,
                    'package_id' => $item->id,
                    'price' => $item->price,
                ]);
                if ($newOrder->user->whatsapp == null) {
                    $orderActive = false;
                }
            } elseif ($item->associatedModel->model == 'Product') {
                Order_Details::create([
                    'order_id' => $newOrder->id,
                    'product_id' => $item->id,
                    'price' => $item->price,
                ]);
                if ($item->associatedModel->folio == 1 && $newOrder->user->whatsapp == null) {
                    $orderActive = false;
                }
            }
        }


        //Actualizar status de orden
        Order::findOrFail($newOrder->id)->update([
            'active' => $orderActive,
        ]);

        \Cart::clear();



        return redirect()->route('order.show', [$newOrder->id]);
    }
}

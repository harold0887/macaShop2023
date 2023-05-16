<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\Order_Details;
use App\Mail\PaymentApprovedEmail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\Product;

class MainController extends Controller
{
    //envios reales pagina web
    public function thanks_you() //Metodo al que retorna al finalizar la compra
    {
        $newOrder = Order::create([
            'customer_id' => Auth::user()->id,
            'amount' => \Cart::getTotal(),
            'status' => request('status'),
            'payment_type' => request('payment_type'),
            'payment_id' => request('payment_id'),
            'order_id' => request('merchant_order_id')
        ]);


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
        \Cart::clear();


        switch (request('status')) {
            case 'approved':
                //enviar email de compra
                $correo = new PaymentApprovedEmail($newOrder->id, Auth::user()->name);
                Mail::to(Auth::user()->email)
                    ->cc('arnulfoacosta0887@gmail.com')
                    ->send($correo);
                return view('shop.success', compact('productosCart', 'Total', 'order', 'payment_type'));
                break;
            case 'pending':
                $correo = new PaymentApprovedEmail($newOrder->id, Auth::user()->name);
                Mail::to(Auth::user()->email)
                    //->cc('arnulfoacosta0887@gmail.com')
                    ->send($correo);
                return view('shop.pending', compact('productosCart', 'Total', 'lastOrderCustomer_id', 'payment_type'));
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
      public function thanks_you1() //recepcion de noticias automatica de mercado pago
      {
  
          $lastOrderAll = Order::take(1)->orderByDesc('id')->select('id')->get();
          $status = "approved";
          $payment_type = "credit_card";
          $payment_id = $lastOrderAll[0]->id++;
  
  
          $newOrder=Order::create([
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
    public function customerMemberships()
    {
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
        return view('account.account-packages',compact('packages'));
     
    }

    public function search(Request $request){
        $term= $request->get('term');

        $query= Product::where('name','LIKE','%'.$term.'%')
        ->orderBy('title')
        ->get();

        $data=[];

        foreach ($query as $q) {
           $data[]=[
            'label'=>$q->title,
            'value'=>$q->slug
           ];
        }

        return $data;
    }
}

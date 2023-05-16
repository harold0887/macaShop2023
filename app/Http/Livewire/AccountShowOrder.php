<?php

namespace App\Http\Livewire;

use ErrorException;
use App\Models\Order;

use App\Models\Product;

use Livewire\Component;
use App\Mail\EnvioMaterial;
use App\Models\Order_Details;
use App\Http\Helpers\AddLicense;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use setasign\Fpdi\Fpdi; // Like this
use Illuminate\Database\QueryException;
use setasign\Fpdi\PdfParser\CrossReference\CrossReferenceException;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;

class AccountShowOrder extends Component
{

    public $order;
    public  $product;
    public function mount($id)
    {
        $this->order = Order::findOrFail($id);
    }


    public function render()
    {
        $order = Order::where('customer_id', Auth::user()->id)
            ->where('orders.id', $this->order->id)
            ->firstOrFail();




        $purchases = Order_Details::join('orders', 'order_details.order_id', '=', 'orders.id')
            ->join('products', 'order_details.product_id', '=', 'products.id')
            ->where('orders.customer_id', Auth::user()->id)
            ->where('orders.id', $this->order->id)
            ->select(
                'products.id',
                'products.itemMain',
                'products.title',
                'products.format',
                'orders.status',
                'orders.id as order_id',
                'order_details.price'
            )
            ->orderBy('products.title')
            ->get();


        $packages = Order_Details::join('orders', 'order_details.order_id', '=', 'orders.id')
            ->join('packages', 'order_details.package_id', '=', 'packages.id')
            ->where('orders.customer_id', Auth::user()->id)
            ->where('orders.id', $this->order->id)
            ->select(
                'packages.id',
                'packages.itemMain',
                'packages.title',
                'packages.status',
                'order_details.price'
            )
            ->orderBy('packages.title')
            ->get();

        $memberships = Order_Details::join('orders', 'order_details.order_id', '=', 'orders.id')
            ->join('memberships', 'order_details.membership_id', '=', 'memberships.id')
            ->where('orders.customer_id', Auth::user()->id)
            ->where('orders.id', $this->order->id)
            ->select(
                'memberships.id',
                'memberships.itemMain',
                'memberships.title',
                'memberships.status',
                'memberships.expiration',
                'order_details.price'
            )->orderBy('memberships.title')
            ->get();



        return view('livewire.account-show-order', compact('purchases', 'order', 'packages', 'memberships'))
            ->extends('layouts.app', [
                'title' => 'Mis compras',
                'navbarClass' => 'navbar-transparent',
                'activePage' => 'orders',
                'menuParent' => 'orders',
            ])
            ->section('content');
    }

    // public function downloadDocumentCustomer($id)
    // {
    //     //mostrar terminos y condiciones
    //     $this->emit('terminos', [
    //         'id' => $id,
    //     ]);
    // }
    public function finalDownload($id)
    {
        $this->product = Product::findOrFail($id);



        $orderId = Order_Details::join('orders', 'order_details.order_id', '=', 'orders.id')
            ->where('orders.customer_id', Auth::user()->id)
            ->where('order_details.product_id', $id)
            ->where('orders.status', 'approved')
            ->get()
            ->count();
        try {
            if ($orderId > 0) {

                if ($this->product->format == 'pdf') {

                    //agregar licencia
                    $addLicense = new AddLicense($id, $this->order->id);
                    if ($addLicense->setLicense()) {
                        $file = "pdf/newpdf.pdf";
                        return response()->download($file, $this->product->title . ".pdf");
                    }
                } else {
                    $file = "./storage/" . $this->product->document;
                    return response()->download($file, $this->product->title . "." . $this->product->format);
                }
            } else {
                $this->emit('error', [
                    'message' => 'No tiene permiso para descargar: ' . $this->product->title,
                ]);
            }
        } catch (QueryException $e) {
            $this->emit('error', [
                'message' => 'No se pudo descargar el archivo - ' . $this->product->title . ' - ' . $e->getMessage(),
            ]);
        } catch (FileNotFoundException $e) {
            $this->emit('error', [
                'message' => 'El archivo no existe - ' . $this->product->title . ' - ' . $e->getMessage(),
            ]);
        } catch (CrossReferenceException $e) {
            $this->emit('error', [
                'message' => 'No se pudo convertir el archivo - ' . $this->product->title . ' - ' . $e->getMessage(),
            ]);
        } catch (ErrorException  $e) {
            $this->emit('error', [
                'message' => 'No se pudo descargar el archivo    - ' . $this->product->title . ' - ' . $e->getMessage(),
            ]);
        } finally {
            $this->emit('alertDownload', [
                'message' => "<span class='text-sm'><b>Importante !</b> - Si tiene problemas con la descarga, se recomienda descargar desde una computadora.</span>"
            ]);
        }
    }



    public function sendEmail($id)
    {
        $this->product = Product::findOrFail($id);



        $orderId = Order_Details::join('orders', 'order_details.order_id', '=', 'orders.id')
            ->where('orders.customer_id', Auth::user()->id)
            ->where('order_details.product_id', $id)
            ->where('orders.status', 'approved')
            ->get()
            ->count();
        try {
            if ($orderId > 0) {

                //agregar licencia

                if ($this->product->format == 'pdf') {

                    //agregar licencia
                    $addLicense = new AddLicense($id, $this->order->id);
                    if ($addLicense->setLicense()) {

                        set_time_limit(0);
                        $correo = new EnvioMaterial($this->product);
                        Mail::to(Auth::user()->email)->send($correo);
                        $this->emit('sendSuccessHtml', [
                            'note' => 'Se han enviado correctamente a: ',
                            'product' => $this->product->title,
                            'email' => Auth::user()->email
                        ]);
                    }
                } else {
                    $correo = new EnvioMaterial($this->product);
                    Mail::to(Auth::user()->email)->send($correo);
                    $this->emit('sendSuccessHtml', [
                        'note' => 'Se han enviado correctamente a: ',
                        'product' => $this->product->title,
                        'email' =>Auth::user()->email
                    ]);
                }
            } else {
                $this->emit('error', [
                    'message' => 'No tiene permiso para enviar: ' . $this->product->title,
                ]);
            }
        } catch (QueryException $e) {
            $this->emit('error', [
                'message' => 'No se pudo enviar el archivo - ' . $this->product->title . ' - ' . $e->getMessage(),
            ]);
        } catch (FileNotFoundException $e) {
            $this->emit('error', [
                'message' => 'El archivo no existe - ' . $this->product->title . ' - ' . $e->getMessage(),
            ]);
        } catch (CrossReferenceException $e) {
            $this->emit('error', [
                'message' => 'No se pudo convertir el archivo - ' . $this->product->title . ' - ' . $e->getMessage(),
            ]);
        } catch (ErrorException  $e) {
            $this->emit('error', [
                'message' => 'No se pudo enviar el archivo    - ' . $this->product->title . ' - ' . $e->getMessage(),
            ]);
        } finally {
            $this->emit('alertDownload', [
                'message' => "<span class='text-sm'><b>Importante !</b> - Si tiene problemas con la descarga, se recomienda descargar desde una computadora.</span>"
            ]);
        }
    }
}

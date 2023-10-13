<?php

namespace App\Http\Livewire;

use App\Models\Ip;
use ErrorException;
use App\Models\Order;
use App\Models\Package;
use App\Models\Product;

use Livewire\Component;

use App\Models\Membership;
use App\Mail\EnvioMaterial;
use Illuminate\Http\Request;
use App\Models\Order_Details;
use App\Http\Helpers\AddLicense;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use setasign\Fpdi\Fpdi; // Like this
use Illuminate\Database\QueryException;
use setasign\Fpdi\PdfParser\CrossReference\CrossReferenceException;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;

class AccountShowMembership extends Component
{
    public $membership, $product, $order;
    public $productModal;
    public $sortDirection = 'asc';
    public $sortField = 'numero';
    public $products;
    public $ids;

    public function mount($order, $id)
    {
       
        $this->membership = Membership::findOrFail($id);
        $this->ids = $id;



        //dd( $this->membership);
        $this->order = Order::findOrFail($order);
    }
    public function render()
    {
        $this->products = Membership::find($this->ids)->products()->orderBy($this->sortField, $this->sortDirection)->get();

        $membershipCount = Order_Details::join('orders', 'order_details.order_id', '=', 'orders.id')
            ->join('memberships', 'order_details.membership_id', '=', 'memberships.id')
            ->where('orders.customer_id', Auth::user()->id)
            ->where('order_details.membership_id', $this->membership->id)
            ->where('memberships.expiration', '>', now())
            ->where('orders.status', 'approved')
            ->get()
            ->count();

        if ($membershipCount > 0) {
            return view('livewire.account-show-membership')
                ->extends('layouts.app', [
                    'title' => $this->membership->title,
                    'navbarClass' => 'navbar-transparent',
                    'activePage' => 'memberships',
                    'menuParent' => 'orders',
                ])
                ->section('content');
        } else {
            abort(404);
        }
    }
    public function finalDownload($id)
    {
        $this->product = Product::findOrFail($id);



        $orderId = Order_Details::join('orders', 'order_details.order_id', '=', 'orders.id')
            ->join('memberships', 'order_details.membership_id', '=', 'memberships.id')
            ->where('orders.customer_id', Auth::user()->id)
            ->where('order_details.membership_id', $this->membership->id)
            ->where('memberships.expiration', '>', now())
            ->where('orders.status', 'approved')
            ->get()
            ->count();


        try {
            if ($orderId > 0) {

                //validar si es un PDF y que tenga folio activado
                if ($this->product->format == 'pdf' && $this->product->folio == 1) {

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
            ->join('memberships', 'order_details.membership_id', '=', 'memberships.id')
            ->where('orders.customer_id', Auth::user()->id)
            ->where('order_details.membership_id', $this->membership->id)
            ->where('memberships.expiration', '>', now())
            ->where('orders.status', 'approved')
            ->get()
            ->count();


        try {

            if ($orderId > 0) {


                //validar si es un PDF y que tenga folio activado
                if ($this->product->format == 'pdf' && $this->product->folio == 1) {

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
                        'email' => Auth::user()->email
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
        } catch (\Throwable $e) {
            $this->emit('error', [
                'message' => 'Error al enviar el email - ' . $e->getMessage(),
            ]);
        } finally {
            $this->emit('alertDownload', [
                'message' => "<span class='text-sm'><b>Importante !</b> - Si tiene problemas con la descarga, se recomienda descargar desde una computadora.</span>"
            ]);
        }
    }


    public function setProduct($id)
    {
        $this->reset('productModal');
        $this->productModal = Product::findOrFail($id);

        $this->emit('showAcordeon');
    }


    public function setSort($sort, $direction)
    {
        $this->sortField = $sort;
        $this->sortDirection = $direction;
    }
}

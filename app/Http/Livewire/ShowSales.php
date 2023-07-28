<?php

namespace App\Http\Livewire;

use App\Models\Order;
use App\Models\Enviado;
use App\Models\Package;
use App\Models\Product;
use Livewire\Component;

use App\Models\Shipment;

use App\Models\Order_Details;

use App\Http\Helpers\AddLicense;
use App\Models\PackageAsProduct;
use setasign\Fpdi\Fpdi; // Like this
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Request;

class ShowSales extends Component
{
    public $patch, $ids, $order, $idPackage, $count = 0;
    public $socialNetwork;

    protected $listeners = ['some-event1' => '$refresh'];
    protected $rules = [
        'socialNetwork' => 'required|string',
    ];
    protected $messages = [
        'socialNetwork.required' => 'El WhatsApp no puede estar vacío',
    ];

    public function mount()
    {
        $patch = Request::fullUrl();
        $this->patch = Request::fullUrl();
        $div = explode("/", $patch);
        $this->ids = $div[5];
        $this->order = Order::findOrFail($this->ids);
        $this->idPackage = 1000;
        $this->socialNetwork = $this->order->contacto;

        //dd($this->order);
    }
    public function render()
    {
        $purchases = Order_Details::join('orders', 'order_details.order_id', '=', 'orders.id')
            ->join('products', 'order_details.product_id', '=', 'products.id')
            ->where('order_details.order_id', $this->ids)
            ->orderBy('products.title')
            ->select(
                'products.id',
                'products.itemMain',
                'order_details.price',
                'orders.active',
                'products.title',
                'products.folio',
                'products.document',
            )->get();

        $packages = Package::join('order_details', 'order_details.package_id', '=', 'packages.id')
            ->join('orders', 'order_details.order_id', '=', 'orders.id')
            ->where('order_details.order_id', $this->ids)
            ->orderBy('packages.title')
            ->select('packages.id', 'packages.model', 'packages.itemMain', 'packages.price', 'packages.title', 'orders.active', 'orders.id as order_id')
            ->get();



        $memberships = Order_Details::join('orders', 'order_details.order_id', '=', 'orders.id')
            ->join('memberships', 'order_details.membership_id', '=', 'memberships.id')
            ->where('order_details.order_id', $this->ids)
            ->orderBy('memberships.title')
            ->select(
                'memberships.id',
                'memberships.itemMain',
                'order_details.price',
                'memberships.title',
                'orders.active',
                'orders.id as order_id',
                'order_details.id as idOrder'
            )->get();

        $productsPackagesOrder = PackageAsProduct::join('products', 'package_product.product_id', 'products.id')
            ->where('package_product.package_id', $this->idPackage)
            ->select('products.title', 'products.id', 'products.itemMain', 'products.price', 'products.status', 'products.folio')
            ->orderBy('title')
            ->get();




        return view('livewire.show-sales', compact('purchases', 'packages', 'memberships', 'productsPackagesOrder'));
    }

    public function showPackages($idPackage)
    {
        $this->idPackage = $idPackage;
    }

    public function download(Product $product)
    {


        try {
            if ($product->format == 'pdf') {

                $addLicense = new AddLicense($product->id, $this->order->id);


                if ($addLicense->download()) {
                    $file = "pdf/newpdf.pdf";

                    return response()->download($file, "w" . $this->order->user->id . ' - ' . $product->title . ".pdf");
                }
            } else {
                $this->emit('error', [
                    'message' => 'Error al descargar el documento -  No es un PDF',
                ]);
            }
        } catch (\Throwable $th) {
            $this->emit('error', [
                'message' => 'error al descargar el documento - ' . $th->getMessage(),
            ]);
        }
    }


    public function activeOrder()
    {
        $this->validate();

        try {
            $venta = Order::findOrFail($this->order->id);
            $status = $venta->active;

            $venta->update([
                'active' => $status == 0 ? true : false,
                'contacto' => $this->socialNetwork
            ]);
            $this->emit('success-auto-close', [
                'message' => 'El registro web fue actualizado con éxito',
            ]);
        } catch (QueryException $e) {
            $this->emit('error', [
                'message' => $e->getMessage(),
            ]);
        } finally {
            $this->emit('some-event1');
        }
    }
}

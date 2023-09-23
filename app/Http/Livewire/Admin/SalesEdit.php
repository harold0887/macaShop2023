<?php

namespace App\Http\Livewire\Admin;

use App\User;
use App\Models\Order;
use App\Models\Package;
use App\Models\Product;
use Livewire\Component;
use App\Models\Membership;
use App\Models\Order_Details;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Request;

class SalesEdit extends Component
{
    protected $listeners = ['some-event2' => '$refresh'];
    public $order, $ids, $patch, $search = '', $contacto, $status, $mercadoPago, $facebook, $comentario;
    protected $rules = [
        'contacto' => ['required', 'string'],
        'facebook' => 'required|string',
    ];
    public function mount()
    {
        $patch = Request::fullUrl();
        $this->patch = Request::fullUrl();
        $div = explode("/", $patch);
        $this->ids = $div[5];

        $this->order = Order::findOrFail($this->ids);
        $this->contacto = $this->order->user->whatsapp;
        $this->facebook = $this->order->user->facebook;
        $this->status = $this->order->status;
        $this->mercadoPago = $this->order->payment_id;
        $this->comentario = $this->order->contacto;
    }
    public function render()
    {
        $products = Product::where('price', '>', 0)
            ->where(function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%');
            })
            ->orderBy('title')
            ->get();


        $packages = Package::where('status', true)
            ->where('price', '>', 0)
            ->orderBy('title')
            ->get();



        $memberships = Membership::where('status', true)
            ->where('price', '>', 0)
            ->orderBy('title')
            ->get();

        $productsIncluded = Order_Details::join('products', 'order_details.product_id', 'products.id')

            ->where('order_details.order_id', $this->order->id)
            ->select('products.title', 'products.id', 'products.itemMain', 'order_details.price')
            ->orderBy('title')
            ->get();



        $PackagesIcluded = Order_Details::join('packages', 'order_details.package_id', 'packages.id')

            ->where('order_details.order_id', $this->order->id)
            ->select('packages.title', 'packages.id', 'packages.itemMain', 'order_details.price')
            ->orderBy('title')
            ->get();



        $MembershipsIcluded = Order_Details::join('memberships', 'order_details.membership_id', 'memberships.id')

            ->where('order_details.order_id', $this->order->id)
            ->select('memberships.title', 'memberships.id', 'memberships.itemMain', 'order_details.price')
            ->orderBy('title')
            ->get();


        $sumaProductos = Order_Details::join('products', 'order_details.product_id', 'products.id')

            ->where('order_details.order_id', $this->order->id)
            ->sum('order_details.price');


        $sumaPackages = Order_Details::join('packages', 'order_details.package_id', 'packages.id')

            ->where('order_details.order_id', $this->order->id)
            ->sum('order_details.price');



        $sumaMembresias = Order_Details::join('memberships', 'order_details.membership_id', 'memberships.id')

            ->where('order_details.order_id', $this->order->id)
            ->sum('order_details.price');



        $suma = $sumaProductos + $sumaMembresias + $sumaPackages;



        return view('livewire.admin.sales-edit', compact('products', 'packages', 'memberships', 'suma', 'productsIncluded', 'MembershipsIcluded', 'PackagesIcluded'))
            ->extends('layouts.app', [
                'title' => 'Ventas',
                'navbarClass' => 'navbar-transparent',
                'activePage' => 'sales',
            ])
            ->section('content');
    }


    public function addProduct($id)
    {
        $product = Product::findOrFail($id);
        $this->order->products()->attach($id, [
            'price' => $product->price_with_discount,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
    public function removeProduct($id)
    {
        $this->order->products()->detach($id);
    }


    public function addPackage($id)
    {
        $package = Package::findOrFail($id);
        $this->order->Packages()->attach($id, [
            'price' => $package->price_with_discount,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
    public function removePackage($id)
    {
        $this->order->Packages()->detach($id);
    }


    public function addMembership($id)
    {
        $membership = Membership::findOrFail($id);
        $this->order->Memberships()->attach($id, [
            'price' => $membership->price_with_discount,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
    public function removeMembership($id)
    {
        $this->order->Memberships()->detach($id);
    }

    public function clearSearch()
    {
        $this->reset(['search']);
    }

    public function save()
    {

        try {
            if ($this->order->memberships->count() > 0) {

                $this->validate();
            } else {

                $this->validate([
                    'contacto' => 'required|string',
                ]);
            }

            Order::findOrFail($this->order->id)->update([
                'status' => $this->status,
                'payment_id' => $this->mercadoPago,
                'contacto' => $this->comentario,
            ]);
            User::findOrFail($this->order->customer_id)->update([
                'whatsapp' => $this->contacto,
                'facebook' => $this->facebook,

            ]);
            $this->emit('success-auto-close', [
                'message' => 'La orden fue actualizada de manera correcta',
            ]);
        } catch (QueryException $th) {
            $this->emit('error', [
                'message' => 'Error al actualizar la orden' . $th->getMessage(),
            ]);
        }
    }


    public function activeOrder()
    {
        $venta = Order::findOrFail($this->order->id);

        try {

            $status = $venta->active;

            if ($status == false) {

                if ($this->order->memberships->count() > 0) {

                    $this->validate();
                } else {

                    $this->validate([
                        'contacto' => 'required|string',
                    ]);
                }

                Order::findOrFail($this->order->id)->update([
                    'status' => $this->status,
                    'payment_id' => $this->mercadoPago,
                    'contacto' => $this->comentario,
                ]);
                User::findOrFail($this->order->customer_id)->update([
                    'whatsapp' =>  $this->contacto,
                    'facebook' => $this->facebook,

                ]);
                $this->emit('success-auto-close', [
                    'message' => 'La orden fue actualizada de manera correcta',
                ]);
            }



            $venta->update([
                'active' => $status == 0 ? true : false,
            ]);
            $this->emit('success-auto-close', [
                'message' => 'El status se cambio de manera correcta',
            ]);
        } catch (QueryException $e) {
            $this->emit('error', [
                'message' => $e->getMessage(),
            ]);
        } finally {
            $this->emit('some-event2');
        }
    }
}

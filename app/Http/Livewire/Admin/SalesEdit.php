<?php

namespace App\Http\Livewire\Admin;

use App\Models\Order;
use App\Models\Package;
use App\Models\Product;
use Livewire\Component;
use App\Models\Membership;
use App\Models\Order_Details;
use Illuminate\Support\Facades\Request;

class SalesEdit extends Component
{
    public $order, $ids, $patch, $search = '', $contacto, $status;
    public function mount()
    {
        $patch = Request::fullUrl();
        $this->patch = Request::fullUrl();
        $div = explode("/", $patch);
        $this->ids = $div[5];

        $this->order = Order::findOrFail($this->ids);
        $this->contacto = $this->order->contacto;
        $this->status = $this->order->status;
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
        Order::findOrFail($this->order->id)->update([
          
            'status' => $this->status,
            'contacto' => $this->contacto,
            
            
        ]);


        $this->emit('success-auto-close', [
            'message' => 'La orden due actualizada de manera correcta' . $this->status,
        ]);
    }
}

<?php

namespace App\Http\Livewire;

use App\Models\Package;
use App\Models\Product;
use Livewire\Component;
use App\Models\Membership;
use Illuminate\Support\Facades\Storage;

class MembershipRender extends Component
{
    public $img, $title, $price;
    public function render()
    {

        $memberships = Membership::where('status', true)
            ->get();
        return view('livewire.membership-render', compact('memberships'))
            ->extends('layouts.app', [
                'class' => 'off-canvas-sidebar',
                'classPage' => 'login-page',
                'activePage' => 'membership',
                'title' => "Membresía VIP",
                'navbarClass' => 'text-primary'
            ])

            ->section('content');
    }

    public function addCart($id, $model)
    {

        if ($model == "Product") {
            $product = Product::find($id);
        }
        if ($model == "Membership") {
            $product = Membership::find($id);
        }
        if ($model == "Package") {
            $product = Package::find($id);
        }


        $this->img=Storage::url($product->itemMain);
        $this->title=$product->title;
        $this->price=$product->price;

        \Cart::add(array(
            'id' => $product->id,
            'name' => $product->title,
            'price' => $product->price,
            'quantity' => 1,
            'attributes' => array([]),
            'associatedModel' => $product
        ));


        $this->emit('cart:update');
        $this->emit('addCartAlert');
    }
}

<?php

namespace App\Http\Livewire;

use App\Models\Package;
use App\Models\Product;
use Livewire\Component;
use App\Models\Membership;
use Illuminate\Support\Facades\Storage;

class MembershipShow extends Component
{
    public $img, $title, $price;
    public $membership;

    public function mount($id)
    {
        $this->membership = Membership::findOrFail($id);
    }
    public function render()
    {
        return view('livewire.membership-show')
            ->extends('layouts.app', [
                'class' => 'off-canvas-sidebar',
                'classPage' => 'login-page',
                'activePage' => 'membership',
                'title' => "Membresía VIP",
                'navbarClass' => 'text-primary',
                'background'=>'#eee !important'
            ])

            ->section('content');
    }

    public function addCart($id, $model)
    {
        try {
            if ($model == "Product") {
                $product = Product::find($id);
            }
            if ($model == "Package") {
                $product = Package::find($id);
            }
            if ($model == "Membership") {
                $product = Membership::find($id);
            }


            \Cart::add(array(
                'id' => $product->id,
                'name' => $product->title,
                'price' => $product->price_with_discount,
                'quantity' => 1,
                'attributes' => array(
                    'type' => 'Membership',
                ),
                'associatedModel' => $product
            ));



            $this->img = Storage::url($product->itemMain);
            $this->title = $product->title;
            $this->price = $product->price_with_discount;




            $this->emit('cart:update');
            $this->emit('addCartAlert');
        } catch (\Throwable $th) {
            $this->emit('error', [
                'message' => "Error al agregar el producto al carrito - " . $th->getMessage(),
            ]);
        }
    }
}

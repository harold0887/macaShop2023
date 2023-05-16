<?php

namespace App\Http\Livewire;

use App\Models\Package;
use App\Models\Product;
use Livewire\Component;
use App\Models\Membership;

class CartRender extends Component
{
    protected $listeners = [
        'updateCart' => '$refresh',
    ];
    public function render()
    {
        return view('livewire.cart-render')
            ->extends('layouts.app', [
                'class' => 'off-canvas-sidebar',
                'classPage' => 'login-page',
                'activePage' => 'cart',
                'title' => "Carrito",
                'navbarClass' => 'text-primary',
                'background'=>'#eee !important'
            ])

            ->section('content');
    }

    public function remove($id, $title)
    {
        try {
            \Cart::remove($id);
            $this->emit('cart:update');
            $this->emit('deleteCartAlert', [
                'message' => $title . " se ha eliminado del carrito"
            ]);
            $this->emit('reload');
        } catch (\Throwable $th) {
            $this->emit('error', [
                'message' => "Error al eliminar el producto " . $th->getMessage(),
            ]);
        }
    }


    public function loginMessage()
    {
        
    
        $this->emit('alertlogin', [
            'message' => "<span class='text-sm'><b>Importante !</b> - Inicia sesión o registrate para finalizar la compra. </span>
            "
        ]);
    }

    public function createOrder($preference){

        dd($preference);    
    }
}

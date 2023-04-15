<?php

namespace App\Http\Livewire;

use Livewire\Component;

class CartRender extends Component
{
    public function render()
    {
        return view('livewire.cart-render')
            ->extends('layouts.app', [
                'class' => 'off-canvas-sidebar',
                'classPage' => 'login-page',
                'activePage' => 'cart',
                'title' => "Carrito",
                'navbarClass' => 'text-primary'
            ])

            ->section('content');
    }
}

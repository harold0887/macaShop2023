<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;

class Novedades extends Component
{
    public function render()
    {
        $products = Product::where('status', true)
            ->where('price', '>', 0)
            ->take(7)
            ->orderByDesc('created_at')
            ->get();
        return view('livewire.novedades', compact('products'));
    }
}

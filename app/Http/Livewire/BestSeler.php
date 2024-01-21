<?php

namespace App\Http\Livewire;

use App\Models\Package;
use App\Models\Product;
use Livewire\Component;
use App\Models\Membership;
use Illuminate\Support\Facades\Storage;

class BestSeler extends Component

{
    public $img, $title, $price;

    public function render()
    {
        $products =   Product::withCount('sales')

            ->orderBy('sales_count', 'desc')
            ->take(10)
            ->get();



        return view('livewire.best-seler', compact('products'));
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
            $this->emit('addCartAlert', [
                'title' => $this->title,
                'price' => $this->price,
                'image' => $this->img
            ]);
        } catch (\Throwable $th) {
            $this->emit('error', [
                'message' => "Error al agregar el producto al carrito - " . $th->getMessage(),
            ]);
        }
    }
}

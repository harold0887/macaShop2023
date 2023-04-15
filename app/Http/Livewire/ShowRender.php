<?php

namespace App\Http\Livewire;

use App\Models\Comment;
use App\Models\Product;
use Livewire\Component;
use App\Models\Membership;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ShowRender extends Component
{
    public $product, $articles;

    public $newComment;

    protected $listeners = [
        'refreshComponent' => '$refresh'
    ];

    protected $rules = [
        'newComment' => 'required|string',
    ];
    protected $messages = [
        'newComment.required' => 'El comentario no puede estar vacío.',
    ];

    public function mount($id)
    {
        $this->product = Product::where('slug', $id)
            ->firstOrFail();

        $this->articles = Product::where('grade', '=', $this->product->grade)
            ->orderBy('title')
            ->where('price', '>', 0)
      
            ->where('status', true)
            ->whereNotIn('id', [$this->product->id])
            ->take(5)
            ->get();
    }
    public function render()
    {



        return view('livewire.show-render')
            ->extends('layouts.app', [
                'class' => 'off-canvas-sidebar',
                'classPage' => 'login-page',
                'activePage' => 'shop',
                'title' => $this->product->title,
                'navbarClass' => 'text-primary'
            ])

            ->section('content');
    }


    public function addComment()
    {

        $this->validate();


        try {
            Comment::create([
                'comment' => $this->newComment,
                'product_id' => $this->product->id,
                'user_id' => Auth::user()->id,
                'best' => false,
            ]);


            $this->emit('alertComment', [
                'message' => "<span class='text-sm'><b>Gracias !</b> - Su comentario fue registrado correctamentes.</span>"
            ]);
        } catch (\Throwable $th) {
            $this->emit('error', [
                'message' => 'Error al guardar el comentario - ' . $th->getMessage(),
            ]);
        }


        $this->emit('refreshComponent');
        $this->newComment = "";
    }


    public function addCart($id, $model)
    {

        if ($model == "Product") {
            $product = Product::find($id);
        }
        if ($model == "Membership") {
            $product = Membership::find($id);
        }
        //dd($product);
        \Cart::add(array(
            'id' => $product->id,
            'name' => $product->title,
            'price' => $product->price_with_discount,
            'quantity' => 1,
            'attributes' => array([]),
            'associatedModel' => $product
        ));


        $this->emit('cart:update');
        $this->emit('addCartAlert', [
            'itemMain' => Storage::url($product->itemMain),
            'title' => $product->title,
            'price' => $product->price_with_discount,
        ]);
    }















    public function downloadFree($id)
    {
        $product = Product::findOrFail($id);
        if (Auth::check()) {

            if ($product->price > 0) {
                return redirect(route('shop.show', $product->slug));
            } else {
                try {
                    DB::table('descargas')->insert([
                        'id_product' => $product->id,
                        'id_user' => Auth::user()->id,
                    ]);

                    $this->emit('alertDownload', [
                        'message' => "<span class='text-sm'><b>Importante !</b> - Si tiene problemas con la descarga, se recomienda descargar desde una computadora.</span>"
                    ]);
                    return Storage::download('public/' . $product->document, $product->name);
                } catch (\Throwable $th) {
                    $this->emit('error', [
                        'message' => 'Error al descargar el documento - ' . $th->getMessage(),
                    ]);
                }
            }
        } else {
            $this->emit('alertlogin', [
                'message' => "<span class='text-sm'><b>Importante !</b> - Registrate o inicia sesión para descargar este y otros materiales gratuitos. </span>
                "
            ]);
        }
    }
}

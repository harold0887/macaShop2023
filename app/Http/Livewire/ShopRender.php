<?php

namespace App\Http\Livewire;

use App\Models\Grade;
use App\Models\Package;
use App\Models\Product;
use Livewire\Component;
use App\Models\Category;
use App\Models\Membership;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ShopRender extends Component
{

    use WithPagination;
    public $search = '';
    public $categoriesSelect = [];
    public $gradeSelect = [];
    public $img, $title, $price;
    protected $paginationTheme = 'bootstrap';
    public $membership;
    public $icon, $showFilter, $showCategory, $collapseCategory, $showGrade, $collapseGrade;

    


    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function mount()
    {
        $this->membership = Membership::where('main','=',1)->first();
    }


    public function render()
    {
        $busqueaCat = $this->categoriesSelect;
        $busqueaGra = $this->gradeSelect;
        $categories = Category::orderBy('name', 'ASC')
            ->select('name', 'id')
            ->whereNotIn('name', ['gratuito'])
            ->get();
        $degrees = Grade::orderBy('name', 'ASC')
            ->select('name', 'id')
            ->get();


        $products = Product::where(function ($query) {
            $query->where('title', 'like', '%' . $this->search . '%')
                ->orWhere('information', 'like', '%' . $this->search . '%');
        })->where('price', '>', 0)
            ->where('status',  true)
            ->orderBy('created_at', 'desc')
            ->whereNotIn('title', ['newsDesktop','newsMobile'])
            ->paginate(40);

        $packages = Package::where(function ($query) {
            $query->where('title', 'like', '%' . $this->search . '%');
            //->orWhere('information', 'like', '%' . $this->search . '%');
        })->where('price', '>', 0)
            ->where('status',  true)
            ->orderBy('created_at', 'desc')
            ->get();





        if (!empty($this->categoriesSelect)) {
            $products = Product::where(function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('information', 'like', '%' . $this->search . '%');
            })->where('price', '>', 0)
                ->where('status',  true)
                ->orderBy('created_at', 'desc')
                ->whereHas('categorias', function ($query) use ($busqueaCat) {
                    $query->whereIn('categories.id', $busqueaCat);
                })
                ->whereNotIn('title', ['newsDesktop','newsMobile'])
                ->paginate(40);
        }

        if (!empty($this->gradeSelect)) {
            $products = Product::where(function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('information', 'like', '%' . $this->search . '%');
            })->where('price', '>', 0)
                ->where('status',  true)
                ->orderBy('created_at', 'desc')
                ->whereIn('grade',  $this->gradeSelect)
                ->whereNotIn('title', ['newsDesktop','newsMobile'])
                ->paginate(40);
        }

        if (!empty($this->categoriesSelect) && !empty($this->gradeSelect)) {
            $products = Product::where(function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('information', 'like', '%' . $this->search . '%');
            })->where('price', '>', 0)
                ->where('status',  true)
                ->orderBy('created_at', 'desc')
                ->whereIn('grade',  $this->gradeSelect)
                ->whereHas('categorias', function ($query) use ($busqueaCat) {
                    $query->whereIn('categories.id', $busqueaCat);
                })
                ->whereNotIn('title', ['newsDesktop','newsMobile'])
                ->paginate(40);
        }






        return view('livewire.shop-render', compact('products', 'categories', 'degrees', 'packages'))
            ->extends('layouts.app', [
                'class' => 'off-canvas-sidebar',
                'classPage' => 'login-page',
                'activePage' => 'shop',
                'title' => "Tienda",
                'navbarClass' => 'text-primary',
                'pageBackground' => asset("material").'/img/markus-spiske-187777.jpg',
                'background'=>'#eee !important'
            ])

            ->section('content');
    }

    public function clearSearch()
    {
        $this->reset(['search']);
    }

    public function clearCategories()
    {
        $this->reset(['categoriesSelect']);
    }
    public function clearGrade()
    {
        $this->reset(['gradeSelect']);
    }

    public function setCategory($id)
    {
        $this->categoriesSelect = [$id];
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

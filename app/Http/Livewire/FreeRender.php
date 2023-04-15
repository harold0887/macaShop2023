<?php

namespace App\Http\Livewire;

use App\Models\Grade;
use App\Models\Product;
use Livewire\Component;
use App\Models\Category;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FreeRender extends Component
{
    use WithPagination;
    public $search = '';
    public $categoriesSelect = [];
    public $gradeSelect = [];
    protected $paginationTheme = 'bootstrap';

    public function updatingSearch()
    {
        $this->resetPage();
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
        })->where('price', '=', 0)
            ->orderBy('title')
            ->where('status',  true)
            ->orderBy('created_at', 'desc')
            ->paginate(40);


        if (!empty($this->categoriesSelect)) {
            $products = Product::where(function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('information', 'like', '%' . $this->search . '%');
            })->where('price', '=', 0)
                ->where('status',  true)
                ->orderBy('created_at', 'desc')
                ->whereHas('categorias', function ($query) use ($busqueaCat) {
                    $query->whereIn('categories.id', $busqueaCat);
                })
                ->paginate(40);
        }

        if (!empty($this->gradeSelect)) {
            $products = Product::where(function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('information', 'like', '%' . $this->search . '%');
            })->where('price', '=', 0)
                ->where('status',  true)
                ->orderBy('created_at', 'desc')
                ->whereIn('grade',  $this->gradeSelect)
                ->paginate(40);
        }

        if (!empty($this->categoriesSelect) && !empty($this->gradeSelect)) {
            $products = Product::where(function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('information', 'like', '%' . $this->search . '%');
            })->where('price', '=', 0)
                ->where('status',  true)
                ->orderBy('created_at', 'desc')
                ->whereIn('grade',  $this->gradeSelect)
                ->whereHas('categorias', function ($query) use ($busqueaCat) {
                    $query->whereIn('categories.id', $busqueaCat);
                })
                ->paginate(40);
        }



        return view('livewire.free-render', compact('products', 'categories', 'degrees'))
            ->extends('layouts.app', [
                'class' => 'off-canvas-sidebar',
                'classPage' => 'login-page',
                'activePage' => 'free',
                'title' => "Material gratuito",
                'navbarClass' => 'text-primary'
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

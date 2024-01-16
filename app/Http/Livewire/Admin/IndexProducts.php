<?php

namespace App\Http\Livewire\Admin;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class IndexProducts extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $search = '';
    public $sortDirection = 'desc';
    public $sortField = 'created_at';
    protected $listeners = [
        'delete' => 'delete',
    ];
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $products = Product::where(function ($query) {
            $query->where('title', 'like', '%' . $this->search . '%');
        })->withCount('sales')
            ->withCount('descargas')
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(50);

       

        return view('livewire.admin.index-products', compact('products'));
    }

    public function delete($id)
    {
        try {

            $product = Product::findOrFail($id);
            $items = $product->items;
            Product::destroy($product->id);
            if ($product->itemMain) {
                File::delete(storage_path("/app/public/{$product->itemMain}"));
            }

            if ($product->document) {
                File::delete(storage_path("/app/public/{$product->document}"));
            }

            if ($product->video) {
                File::delete(storage_path("/app/public/{$product->video}"));
            }


            foreach ($items as $item) {
                if ($item->photo) {
                    File::delete(storage_path("/app/public/{$item->photo}"));
                }
            }



            $this->emit('success', [
                'title' => 'Eliminado!',
                'message' => 'El archivo ha sido eliminado correctamente.',
            ]);
        } catch (QueryException $e) {


            $this->emit('error', [
                'message' => 'Error al eliminar el registro - ' . $e->getMessage(),
            ]);
        }
    }
    public function changeStatus($id, $status)
    {
        try {
            Product::findOrFail($id)->update([
                'status' => $status == 0 ? true : false
            ]);
            $this->emit('success-auto-close', [
                'message' => 'El cambio se realizo con éxito',
            ]);
        } catch (QueryException $e) {
            $this->emit('error', [
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function changeFolio($id, $status)
    {
        try {
            Product::findOrFail($id)->update([
                'folio' => $status == 0 ? true : false
            ]);
            $this->emit('success-auto-close', [
                'message' => 'El cambio se realizo con éxito',
            ]);
        } catch (QueryException $e) {
            $this->emit('error', [
                'message' => $e->getMessage(),
            ]);
        }
    }

    //sort
    public function setSort($field)
    {

        $this->sortField = $field;

        if ($this->sortDirection == 'desc') {
            $this->sortDirection = 'asc';
        } else {
            $this->sortDirection = 'desc';
        }
    }

    public function clearSearch()
    {
        $this->reset(['search']);
    }

    public function downloadOriginalDocument($id)
    {
        try {
            $document = Product::findOrFail($id);
            return Storage::download('public/' . $document->document, $document->title);
        } catch (\Throwable $th) {
            $this->emit('error', [
                'message' => 'Error al descargar el documento - ' . $th->getMessage(),
            ]);
        }
    }
}

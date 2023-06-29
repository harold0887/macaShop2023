<?php

namespace App\Http\Livewire;

use App\Models\Item;
use App\Models\Product;
use Livewire\Component;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Request;



class DeleteItems extends Component
{

    public $patch, $ids;

 

    public function mount()
    {
        $patch = Request::fullUrl();
        $this->patch = Request::fullUrl();
        $div = explode("/", $patch);
        $this->ids = $div[5];
    }
    public function render()
    {
        $product = Product::findOrFail($this->ids);
        return view('livewire.delete-items', compact('product'));
    }



    public function delete($id)
    {
        $item = Item::findOrFail($id);
        try {
            Item::destroy($item->id);
            File::delete(storage_path("/app/public/{$item->photo}"));
            $this->emit('success-auto-close', [
                'title' => 'Eliminado!',
                'message' => 'El item ha sido eliminado correctamente.',
            ]);
        } catch (\Throwable $e) {
            $this->emit('error', [
                'message' => 'Error al eliminar el item - ' . $e->getMessage(),
            ]);
        }
    }

    public function deleteItemMain($id)
    {
        $product = Product::findOrFail($id);
        try {
            File::delete(storage_path("/app/public/{$product->itemMain}"));
            $this->emit('success-auto-close', [
                'title' => 'Eliminado!',
                'message' => 'La portada ha sido eliminada correctamente.',
            ]);
            $this->emit('reload');
        } catch (\Throwable $e) {
            $this->emit('error', [
                'message' => 'Error al eliminar el item - ' . $e->getMessage(),
            ]);
        }
    }
    public function deleteDocument($id)
    {
        $product = Product::findOrFail($id);
        try {
            File::delete(storage_path("/app/public/{$product->document}"));
            $this->emit('success-auto-close', [
                'title' => 'Eliminado!',
                'message' => 'El documento ha sido eliminado correctamente.',
            ]);
            $this->emit('reload');
        } catch (\Throwable $e) {
            $this->emit('error', [
                'message' => 'Error al eliminar el item - ' . $e->getMessage(),
            ]);
        }
    }

    public function deleteVideo($id)
    {
        $product = Product::findOrFail($id);
        try {
            Product::findOrFail($id)->update([
                'video' => '',

            ]);
            File::delete(storage_path("/app/public/{$product->video}"));
            $this->emit('success-auto-close', [
                'title' => 'Eliminado!',
                'message' => 'El video ha sido eliminado correctamente.',
            ]);
            $this->emit('reload');
        } catch (\Throwable $e) {
            $this->emit('error', [
                'message' => 'Error al eliminar el item - ' . $e->getMessage(),
            ]);
        }
    }
}

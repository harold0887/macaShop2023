<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;
use App\Models\Membership;
use Illuminate\Support\Facades\Request;

class EditMembership extends Component
{
    public $patch, $ids, $membership;
    protected $listeners = ['refresh-membership' => '$refresh'];

    public function mount()
    {
        $patch = Request::fullUrl();
        $this->patch = Request::fullUrl();
        $div = explode("/", $patch);
        $this->ids = $div[5];
        $this->membership = Membership::findOrFail($this->ids);
    }
    public function render()
    {
        $products = Product::where('status', true)
            ->orderBy('name', 'asc')->get();
        return view('livewire.edit-membership', compact('products'));
    }

    public function addToPackage($id)
    {
        try {
            $this->membership->products()->attach($id);
            $this->emit('refresh-membership');
            $this->emit('success-auto-close', [
                'message' => 'Archivo agregado correctamente.',
            ]);
        } catch (\Throwable $e) {
            $this->emit('error', [
                'message' => 'Error al eliminar el registro - ' . $e->getMessage(),
            ]);
        }
    }
    public function removeToPackage($id)
    {
        try {
            $this->membership->products()->detach($id);
            $this->emit('refresh-membership');
            $this->emit('success-auto-close', [
                'message' => 'Archivo eliminado correctamente.',
            ]);
        } catch (\Throwable $e) {
            $this->emit('error', [
                'message' => 'Error al eliminar el archivo - ' . $e->getMessage(),
            ]);
        }
    }
}

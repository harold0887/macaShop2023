<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Membership;
use Livewire\WithPagination;
use Illuminate\Support\Facades\File;
use Illuminate\Database\QueryException;

class IndexMemberships extends Component
{
    public $search = '';
    public $sortDirection = 'desc';
    public $sortField = 'created_at';
    protected $listeners = [
        'delete' => 'delete',
    ];

    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $memberships = Membership::orderBy($this->sortField, $this->sortDirection)
            ->where('title', 'like', '%' . $this->search . '%')

            ->paginate(15);
        return view('livewire.admin.index-memberships', compact('memberships'));
    }
    public function delete($id)
    {

        try {
            $object = Membership::findOrFail($id);
            Membership::destroy($id);
            if ($object->itemMain) {
                File::delete(storage_path("/app/public/{$object->itemMain}"));
            }

            $this->emit('success', [
                'title' => 'Eliminado!',
                'message' => 'La membresía ha sido eliminado correctamente.',
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
            Membership::findOrFail($id)->update([
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

    public function changeMain($id, $status)
    {
        $oferta = Membership::findOrFail($id);
        try {

            if ($oferta->price_with_discount>=  $oferta->price ) {
                $this->emit('error', [
                    'message' => "Esta membresía no tiene descuento"
                ]);
            } elseif ($oferta->status == '0') {
                $this->emit('error', [
                    'message' => "Esta membresía no esta activa"
                ]);
            } else {
                $oferta->update([
                    'main' => $status == 0 ? true : false
                ]);
                $this->emit('success-auto-close', [
                    'message' => 'El cambio se realizo con éxito',
                ]);
            }
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
}

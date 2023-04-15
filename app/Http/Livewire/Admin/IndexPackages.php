<?php

namespace App\Http\Livewire\Admin;

use App\Models\Package;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\File;
use Illuminate\Database\QueryException;

class IndexPackages extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $search = '';
    public $sortDirection = 'desc';
    public $sortField = 'created_at';

    protected $listeners = [
        'deletePackage' => 'deletePackage',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function render()
    {
        $packages = Package::where(function ($query) {
            $query->where('packages.title', 'like', '%' . $this->search . '%');
        })->orderBy($this->sortField, $this->sortDirection)
            ->paginate(50);
        return view('livewire.admin.index-packages', compact('packages'));
    }
    public function deletePackage($id)
    {
        try {
            $object = Package::findOrFail($id);
            Package::destroy($id);
            if ($object->itemMain) {
                File::delete(storage_path("/app/public/{$object->itemMain}"));
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
    public function changeStatusPackage($id, $status)
    {
        try {
            Package::findOrFail($id)->update([
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

    public function clearSearch()
    {
        $this->reset(['search']);
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
}

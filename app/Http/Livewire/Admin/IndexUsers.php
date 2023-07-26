<?php

namespace App\Http\Livewire\Admin;

use App\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Database\QueryException;

class IndexUsers extends Component
{
    use WithPagination;
    public $search = '';
    protected $paginationTheme = 'bootstrap';
    public $sortDirection = 'asc';
    public $sortField = 'created_at';

    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function render()
    {
        $users = User::where('users.name', 'like', '%' . $this->search . '%')
            ->orwhere('email', 'like', '%' . $this->search . '%')
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(1000);
        return view('livewire.admin.index-users', compact('users'));
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

    public function changeStatus(User $user)
    {

         try {

            if ($user->hasRole('admin')) {
                $this->emit('error', [
                    'message' => 'No puede cambiar el status a un administrador',
                ]);
            } else {

                if ($user->isNotBanned()) {
                    $user->ban();
                }
                
                $this->emit('success-auto-close', [
                    'message' => 'El usuario ha sido bloqueado con éxito',
                ]);
            }
        } catch (QueryException $e) {
            $this->emit('error', [
                'message' => $e->getMessage(),
            ]);
        }



        // try {
        //     $user = User::findOrFail($id);

        //     if ($user->hasRole('admin')) {
        //         $this->emit('error', [
        //             'message' => 'No puede cambiar el status a un administrador',
        //         ]);
        //     } else {

        //         $user->update([
        //             'status' => $status == 0 ? true : false
        //         ]);

        //         $this->emit('success-auto-close', [
        //             'message' => 'El cambio se realizo con éxito',
        //         ]);
        //     }
        // } catch (QueryException $e) {
        //     $this->emit('error', [
        //         'message' => $e->getMessage(),
        //     ]);
        // }
    }
}

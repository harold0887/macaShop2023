<?php

namespace App\Http\Livewire\Admin;

use App\Models\Ban;
use App\User;
use App\Models\Ips;
use Livewire\Component;
use Mchev\Banhammer\IP;
use Livewire\WithPagination;
use Illuminate\Database\QueryException;

class IndexIps extends Component
{
    use WithPagination;
    public $search = '';
    protected $paginationTheme = 'bootstrap';
    public $sortDirection = 'desc';
    public $sortField = 'id';
    public function updatingSearch()
    {
        $this->resetPage();
    }



    public function render()
    {

        $lock = IP::banned()->get();
        


        $ips = Ips::query()
            ->with(['user'])
            ->when($this->search, function ($query) {
                $query->where('ip', 'like', '%' . $this->search . '%');
            })
            ->orWhereHas('user', function ($query) {
                $query->where('email', 'like', '%' . $this->search . '%')
                    ->orWhere('facebook', 'like', '%' . $this->search . '%')
                    ->orWhere('whatsapp', 'like', '%' . $this->search . '%');
            })

            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(100);


        return view('livewire.admin.index-ips', compact('ips', 'lock'));
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

    public function changeStatus($id, $status)
    {

        $user = User::findOrFail($id);

        try {


            if ($user->hasRole('admin')) {
                $this->emit('error', [
                    'message' => 'No puede cambiar el status a un administrador',
                ]);
            } else {


                if ($status == 1) {

                    $user->ban([
                        'comment' => 'Revendedor'
                    ]);
                    $user->update([
                        'status' => 0,
                    ]);
                    $this->emit('success-auto-close', [
                        'message' => 'El usuario ha sido bloqueado con éxito',
                    ]);
                } else {
                    $user->unban();
                    $user->update([
                        'status' => 1,
                    ]);
                    $this->emit('success-auto-close', [
                        'message' => 'El usuario ha sido desbloqueado con éxito',
                    ]);
                }
            }
        } catch (QueryException $e) {
            $this->emit('error', [
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function bannedIP($ip)
    {
      

            Ban::ban($ip);
      

            $this->emit('success-auto-close', [
                'message' => 'El usuario ha sido bloqueado con éxito',
            ]);

    }

    public function UnBannedIP($ip)
    {

        try {
            IP::unban($ip);

            $this->emit('success-auto-close', [
                'message' => 'El usuario ha sido bloqueado con éxito',
            ]);
        } catch (QueryException $e) {
            $this->emit('error', [
                'message' => $e->getMessage(),
            ]);
        }
    }
}

<?php

namespace App\Http\Livewire\Admin;

use App\User;
use App\Models\Order;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Database\QueryException;

class IndexUsers extends Component
{
    use WithPagination;
    public $search = '';
    protected $paginationTheme = 'bootstrap';
    public $sortDirection = 'desc';
    public $sortField = 'id';
    protected $listeners = [
        'deleteUser' => 'delete',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function render()
    {
        $users = User::where('name', 'like', '%' . $this->search . '%')
            ->orwhere('email', 'like', '%' . $this->search . '%')
            ->orwhere('id', 'like', '%' . $this->search . '%')
            ->orwhere('facebook', 'like', '%' . $this->search . '%')
            ->orwhere('whatsapp', 'like', '%' . $this->search . '%')
            ->withCount('sales')
            ->withCount('ips')
            ->withCount('roles')
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(100);

           

            
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

    public function newSales(User $user)
    {

        //obtener la ultima compra

        $lastOrder = Order::latest()->first();


        try {

            $newOrder = Order::create([
                'customer_id' => $user->id,
                'amount' => 350,
                'status' => 'approved',
                'payment_type' => 'Externo',
                'payment_id' => $lastOrder->payment_id + 1,
                'order_id' => $lastOrder->payment_id + 1,
                'active' => false,
            ]);


            return redirect()->to('dashboard/sales/' . $newOrder->id . '/edit')->with('success-auto-close', 'Registro exitoso');

            //return back()->with('success', 'Registro exitoso');
        } catch (QueryException $e) {
            return back()->with('error', 'Error al guardar el registro - ' .  $e->getMessage());
        }
    }
    public function delete(User $user)
    {
        try {

            User::destroy($user->id);

            $this->emit('success-auto-close', [
                'title' => 'Eliminado!',
                'message' => 'El usuario ha sido eliminado correctamente.',
            ]);
        } catch (QueryException $e) {

            $this->emit('error', [
                'message' => 'Error al eliminar el usuario - ' . $e->getMessage(),
            ]);
        }
    }
}

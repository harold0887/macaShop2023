<?php

namespace App\Http\Livewire\Admin;

use App\Models\Order;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Http;
use Illuminate\Database\QueryException;

class IndexSales extends Component
{
    use WithPagination;
    public $search = '';

    protected $paginationTheme = 'bootstrap';

    public $sortDirection = 'desc';
    public $sortField = 'created_at';
    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function render()
    {
        $orders = Order::query()
            ->with(['user'])
            ->when($this->search, function ($query) {
                $query->where('payment_id', 'like', '%' . $this->search . '%')
                    ->orWhere('status', 'like', '%' . $this->search . '%')
                    ->orWhere('order_id', 'like', '%' . $this->search . '%');
            })
            ->orWhereHas('user', function ($query) {
                $query->where('email', 'like', '%' . $this->search . '%');
            })

            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(100);


        return view('livewire.admin.index-sales', compact('orders'));
    }

    //actualizar orden desde mercado pago
    public function updateStatus($id)
    {
        $response = Http::get("https://api.mercadopago.com/v1/payments/$id" . "?access_token=APP_USR-2311547743825741-013023-3721797a3fbdf97bf2d4ff3f58000481-269113557");

        $response = json_decode($response);
        $newStatus = $response->status;
        try {
            Order::where('payment_id', $id)
                ->firstOrFail()
                ->update([
                    'status' => $newStatus,
                ]);

            $this->emit('success-auto-close', [
                'message' => 'El pago se actualizó con éxito',
            ]);
        } catch (QueryException $e) {
            $this->emit('error', [
                'error' => 'Ocurrio un error al actualizar el pago.',
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

    public function deleteOrder($id)
    {

        try {

            Order::destroy($id);

            $this->emit('deleteSuccess', $id);
        } catch (QueryException $e) {

            if ($e->getCode() == 23000) {
                $messageError = 'La orden tene uno o mas productos asignados.';
            } else {
                $messageError = $e->getMessage();
            }
            $this->emit('deleteError', [
                'error' => 'Error al eliminar el registro - ' . $messageError,
            ]);
        }
    }
}

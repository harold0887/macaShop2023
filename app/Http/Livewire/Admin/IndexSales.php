<?php

namespace App\Http\Livewire\Admin;

use App\Models\Order;
use Livewire\Component;
use Livewire\WithPagination;

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

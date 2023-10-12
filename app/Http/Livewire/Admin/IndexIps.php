<?php

namespace App\Http\Livewire\Admin;

use App\Models\Ip;
use Livewire\Component;

class IndexIps extends Component
{

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
         $ips = Ip::where('ip', 'like', '%' . $this->search . '%')
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(100);
        return view('livewire.admin.index-ips', compact('ips'));
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

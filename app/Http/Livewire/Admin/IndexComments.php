<?php

namespace App\Http\Livewire\Admin;

use App\Models\Comment;
use Livewire\Component;
use Livewire\WithPagination;

class IndexComments extends Component
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




        $comments = Comment::query()
            ->with(['user', 'product'])
            ->when($this->search, function ($query) {
                $query->where('comment', 'like', '%' . $this->search . '%');
            })
            ->orWhereHas('user', function ($q) {
                $q->where('email', 'like', '%' . $this->search . '%')
                    ->orWhere('name', 'like', '%' . $this->search . '%');
            })
            ->orWhereHas('product', function ($q) {
                $q->where('title', 'like', '%' . $this->search . '%');
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(100);








        return view('livewire.admin.index-comments', compact('comments'))
            ->extends('layouts.app', [
                'title' => 'Comentarios',
                'navbarClass' => 'navbar-transparent',
                'activePage' => 'comments',
            ])
            ->section('content');
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

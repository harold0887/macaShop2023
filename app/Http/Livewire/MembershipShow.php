<?php

namespace App\Http\Livewire;

use App\Models\Membership;
use Livewire\Component;

class MembershipShow extends Component
{
    public $membership;

    public function mount($id)
    {
        $this->membership = Membership::findOrFail($id);
    }
    public function render()
    {
        return view('livewire.membership-show')
            ->extends('layouts.app', [
                'class' => 'off-canvas-sidebar',
                'classPage' => 'login-page',
                'activePage' => 'membership',
                'title' => "Membresía VIP",
                'navbarClass' => 'text-primary'
            ])

            ->section('content');
    }
}

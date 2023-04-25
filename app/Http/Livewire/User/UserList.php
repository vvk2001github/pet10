<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Livewire\Component;

class UserList extends Component
{

    public $users;

    public function render()
    {
        return view('livewire.user.user-list');
    }

    public function mount(): void
    {
        $this->users = User::orderBy('name')->get();
    }
}

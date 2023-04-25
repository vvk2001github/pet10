<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Livewire\Component;

class UserList extends Component
{

    public $username;
    public $email;
    public $users;
    public ?User $selectedUser = null;
    public bool $showList = true;
    public bool $showDeleteConfirmation = false;
    public bool $showEdit = false;

    protected $listeners = ['refreshUsers', 'showList'];

    public function deleteUser():void
    {
        if(is_null($this->selectedUser)) return;
        if($this->selectedUser->id == 1) return;
        $this->selectedUser->delete();

        $this->emitSelf('showList');
        $this->emitSelf('refreshUsers');

    }

    public function mount(): void
    {
        $this->users = User::orderBy('name')->get();
    }

    public function render()
    {
        return view('livewire.user.user-list');
    }

    public function selectDeleteUser(User $user):void
    {
        $this->selectedUser = $user;
        $this->showList = false;
        $this->showDeleteConfirmation = true;
        $this->showEdit = false;
    }

    public function selectEditUser(User $user):void
    {
        $this->selectedUser = $user;
        $this->showList = false;
        $this->showDeleteConfirmation = false;
        $this->showEdit = true;
    }

    public function showList():void
    {
        $this->selectedUser = null;
        $this->showList = true;
        $this->showDeleteConfirmation = false;
        $this->showEdit = false;
    }

    public function refreshUsers():void
    {
        // error_log('refreshUsers');
        $this->users = User::orderBy('name')->get();
    }

    public function userAdd(): void
    {
        if (is_null($this->username)) return;

        $newUser = new User();
        $newUser->name = $this->username;
        $newUser->email = $this->email;
        $newUser->password = '';
        $newUser->save();
        $this->reset('username');
        $this->reset('email');
        $this->emitSelf('refreshUsers');
    }
}

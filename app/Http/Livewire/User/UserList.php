<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class UserList extends Component
{

    public $username;
    public $email;
    public $roles;
    public $users;
    public ?User $selectedUser = null;
    public $selectedRoles = [];
    public bool $showList = true;
    public bool $showDeleteConfirmation = false;
    public bool $showEdit = false;

    protected $listeners = ['refreshUsers', 'showUserList'];

    public function deleteUser():void
    {
        /** @var App\User $currentUser */
        $currentUser = auth()->user();
        if(!$currentUser->can('configure.chat')) return;

        if(is_null($this->selectedUser)) return;
        if($this->selectedUser->id == 1) return;
        $this->selectedUser->delete();

        $this->emitSelf('showUserList');
        $this->emitSelf('refreshUsers');

    }

    public function mount(): void
    {
        $this->refreshUsers();
    }

    public function refreshUsers():void
    {
        // error_log('refreshUsers');
        $this->users = User::orderBy('name')->get();
        $this->roles = Role::all();
    }

    public function render()
    {
        return view('livewire.user.user-list');
    }

    protected function rules()
    {
        if($this->showList)
            return [
                'username' => 'required|min:4',
                'email' => 'required|email',
            ];
    }

    public function selectDeleteUser(User $user):void
    {
        /** @var App\User $currentUser */
        $currentUser = auth()->user();
        if(!$currentUser->can('configure.chat')) return;
        $this->selectedUser = $user;
        $this->showList = false;
        $this->showDeleteConfirmation = true;
        $this->showEdit = false;
    }

    public function selectEditUser(User $user):void
    {
        /** @var App\User $currentUser */
        $currentUser = auth()->user();
        if(!$currentUser->can('configure.chat')) return;



        $this->selectedUser = $user;
        $this->selectedRoles = $this->selectedUser->getRoleNames();
        error_log($this->selectedRoles);
        $this->showList = false;
        $this->showDeleteConfirmation = false;
        $this->showEdit = true;
    }

    public function showUserList():void
    {
        $this->selectedUser = null;
        $this->showList = true;
        $this->showDeleteConfirmation = false;
        $this->showEdit = false;
    }

    // Для валидации в реальном времени
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function userAdd(): void
    {
        /** @var App\User $currentUser */
        $currentUser = auth()->user();
        if(!$currentUser->can('configure.chat')) return;

        $this->validate();

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

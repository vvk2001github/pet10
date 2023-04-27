<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class UserList extends Component
{

    public $username;
    public $editemail;
    public $editusername;
    public $editpassword;
    public $editpassword_confirmation;
    public $email;
    public $roles;
    public $users;
    public ?User $selectedUser = null;
    public $selectedRoles = [];
    public bool $showList = true;
    public bool $showDeleteConfirmation = false;
    public bool $showEdit = false;

    protected $listeners = ['refreshUsers', 'showUserList'];
    protected $messages = [
        'editemail.required' => 'The Email Address cannot be empty.',
        'editemail.email' => 'The Email Address format is not valid.',
        'editusername.required' => 'The Name cannot be empty.',
        'editusername.min' => 'The Name must be at least 4 characters.',
    ];

    public function deleteUser():void
    {
        /** @var App\User $currentUser */
        $currentUser = auth()->user();
        if(!$currentUser->can('configure.user')) return;

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

    public function removeAllRoles()
    {
        $this->selectedRoles = [];
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

        if($this->showEdit)
            return [
                'editusername' => 'required|min:4',
                'editemail' => 'required|email',
                'editpassword'=> 'confirmed',
                'editpassword_confirmation'=> '',
            ];
    }

    public function selectDeleteUser(User $user):void
    {
        /** @var App\User $currentUser */
        $currentUser = auth()->user();
        if(!$currentUser->can('configure.user')) return;

        $this->selectedUser = $user;

        // Нельзя удалить такого пользователя
        if($this->selectedUser->id == 1) {
            // $this->addError('bigwarning', 'You cannot delete this user!');
            return;
        }

        $this->showList = false;
        $this->showDeleteConfirmation = true;
        $this->showEdit = false;
    }

    public function selectEditUser(User $user):void
    {
        /** @var App\User $currentUser */
        $currentUser = auth()->user();
        if(!$currentUser->can('configure.user')) return;



        $this->selectedUser = $user;
        $this->selectedRoles = $this->selectedUser->getRoleNames();
        $this->editusername = $this->selectedUser->name;
        $this->editemail = $this->selectedUser->email;
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
        if(!$currentUser->can('configure.user')) return;

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

    public function userSave(): void
    {
        /** @var App\User $currentUser */
        $currentUser = auth()->user();
        if(!$currentUser->can('configure.user')) return;

        $this->validate();

        // Только СуперАдмин может установить роль Super User
        if(!$currentUser->hasRole('Super User')) {
            foreach($this->selectedRoles as $role) {
                if($role == 'Super User') {
                    $this->addError('bigwarning', 'Only Super User can add role Super User!');
                    return;
                }
            }
        }

        $this->selectedUser->name = $this->editusername;
        $this->selectedUser->email = $this->editemail;
        if($this->editpassword && mb_strlen($this->editpassword) > 0 && $this->editpassword_confirmation == $this->editpassword) {
            $this->selectedUser->password = Hash::make($this->editpassword);
        }
        $this->selectedUser->save();
        $this->selectedUser->syncRoles([]);
        foreach($this->selectedRoles as $role) {
            $this->selectedUser->assignRole($role);
        };
        if($this->selectedUser->id == 1) $this->selectedUser->assignRole('Super User');

        $this->reset('username');
        $this->reset('email');
        $this->reset('editpassword');
        $this->reset('editpassword_confirmation');
        $this->emitSelf('refreshUsers');
        $this->emitSelf('showUserList');
    }
}

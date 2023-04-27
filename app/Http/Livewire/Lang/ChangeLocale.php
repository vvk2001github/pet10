<?php

namespace App\Http\Livewire\Lang;

use Livewire\Component;

class ChangeLocale extends Component
{
    public $mylocale;

    public function mount()
    {
        $this->mylocale = session()->get('pet10locale', 'en');
    }

    public function updatedMylocale()
    {
        session(['pet10locale' => $this->mylocale]);
        app()->setLocale($this->mylocale);
        return redirect()->to('/login');
    }

    public function render()
    {
        return view('livewire.lang.change-locale');
    }
}

<?php

namespace App\Http\Livewire\Lang;

use Livewire\Component;

class ChangeLocale extends Component
{
    public $mylocale;

    public $currentUrl;

    public function mount()
    {
        $this->mylocale = session()->get('pet10locale', 'ru');
        $this->currentUrl = url()->current();
    }

    public function updatedMylocale()
    {
        session(['pet10locale' => $this->mylocale]);
        app()->setLocale($this->mylocale);

        return redirect()->to($this->currentUrl);
    }

    public function render()
    {
        return view('livewire.lang.change-locale');
    }
}

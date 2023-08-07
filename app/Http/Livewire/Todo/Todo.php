<?php

namespace App\Http\Livewire\Todo;

use Livewire\Component;

class Todo extends Component
{
    public function render()
    {
        return view('livewire.todo.todo');
    }

    public function setChecked(int $id): void
    {
        dd($id);
    }
}

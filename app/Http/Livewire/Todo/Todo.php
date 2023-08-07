<?php

namespace App\Http\Livewire\Todo;

use App\Models\Todo as ModelTodo;
use Livewire\Component;

class Todo extends Component
{

    public $task ="";
    public $todos;
    public $addFormState = false;

    protected $rules = [
        "task" => "required|min:3",
    ];

    public function deleteTask(int $id): void
    {
        ModelTodo::destroy($id);
    }

    public function messages()
    {
        return [
            "task.min" => __('The task field must be at least 3 characters.'),
        ];
    }

    public function render()
    {
        $this->todos = auth()->user()->todos->sortBy('id');
        return view('livewire.todo.todo');
    }

    public function save(): void
    {
        $data = $this->validate();
        $data['user_id'] = auth()->user()->id;
        ModelTodo::create($data);
        $this->reset();
    }

    public function setChecked(int $id): void
    {
        $todo = ModelTodo::find($id);
        $todo->checked = !$todo->checked;
        $todo->save();
    }

    public function showAddForm(): void
    {
        $this->addFormState = !$this->addFormState;
    }
}

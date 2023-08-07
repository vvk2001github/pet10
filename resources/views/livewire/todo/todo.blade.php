<div class="mx-auto">
    <div class="w-full px-4 md:w-1/12">
        <button wire:click='showAddForm' class="block px-4 py-3 text-white bg-indigo-700 rounded appearance-none">{{__('Add')}}</button>
    </div>
    <div class="px-4 py-3">

    @if ($todos)
    <table class="w-full border-b table-fixed border-x">
        <thead>
            <tr>
                <th class="w-1/12 p-2 font-bold text-left text-white bg-indigo-700 border border-black">#</th>
                <th class="p-2 font-bold text-left text-white bg-indigo-700 border border-black">{{__('Tasks')}}</th>
                <th class="w-1/12 p-2 font-bold text-left text-white bg-indigo-700 border border-black">{{__('Actions')}}</th>
            </tr>
        </thead>
        <tbody>

            @foreach ($todos as $todo)
                <tr class="odd:bg-gray-100 hover:!bg-stone-200 cursor-pointer">
                    <td class="p-2 text-left border-b border-l">
                        <input wire:key='todo-{{ $todo->id }}' wire:click='setChecked({{ $todo->id }})' name="todoChecked[]" type="checkbox"
                        @if($todo->checked)
                            checked
                            @endif
                        />
                    </td>
                    <td class="p-2 text-left border-b border-l">
                        @if ($todo->checked)
                            <s>{{ $todo->task }}</s>
                        @else
                            {{ $todo->task }}
                        @endif

                    </td>

                    <td class="p-2 text-left border-b border-l">
                        <i wire:click='deleteTask({{ $todo->id }})' class="bi bi-trash-fill hover:text-red-900"></i>
                    </td>
                </tr>
            @endforeach

        </tbody>
    </table>

    @endif
    </div>

    @if ($addFormState)
        <div class="w-full px-4 md:w-1/12">
            <form wire:submit.prevent='save'>
                <input wire:model.defer='task' type="text" id="task" class="block w-full px-4 py-3 mb-3 leading-tight border rounded appearance-none">
                @error('task')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </form>
        </div>
    @endif
</div>

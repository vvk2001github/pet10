<div class="mx-auto">
    <div class="w-full px-4 md:w-1/12">
        <button class="block px-4 py-3 text-white bg-indigo-700 rounded appearance-none">{{__('Add')}}</button>
    </div>
    <div class="px-4 py-3">
    <table class="w-full border-b table-fixed border-x">
        <thead>
            <tr>
                <th class="w-1/12 p-2 font-bold text-left text-white bg-indigo-700 border border-black">#</th>
                <th class="p-2 font-bold text-left text-white bg-indigo-700 border border-black">{{__('List')}}</th>
                <th class="w-1/12 p-2 font-bold text-left text-white bg-indigo-700 border border-black">{{__('Actions')}}</th>
            </tr>
        </thead>
        <tbody>
            <tr class="odd:bg-gray-100 hover:!bg-stone-200 cursor-pointer">
                <td class="p-2 text-left border-b border-l">
                    <input wire:key='todo-1' wire:click='setChecked(1)' name="todoChecked" type="checkbox" />
                </td>
                <td class="p-2 text-left border-b border-l">AAAAAAAA</td>

                <td class="p-2 text-left border-b border-l">
                    <i class="bi bi-trash-fill hover:text-red-900"></i>
                </td>
            </tr>

            <tr class="odd:bg-gray-100 hover:!bg-stone-200 cursor-pointer">
                <td class="p-2 text-left border-b border-l">
                    <input wire:key='todo-1' wire:click='setChecked(2)' name="todoChecked" type="checkbox" />
                </td>
                <td class="p-2 text-left border-b border-l"><s>bbbb</s></td>

                <td class="p-2 text-left border-b border-l">
                    <i class="bi bi-trash-fill hover:text-red-900"></i>
                </td>
            </tr>

        </tbody>
    </table>
    </div>
</div>

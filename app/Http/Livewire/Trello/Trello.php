<?php

namespace App\Http\Livewire\Trello;

use App\Models\TrelloCard;
use App\Models\TrelloGroup;
use Livewire\Component;

class Trello extends Component
{
    public $addGroupState = false;

    public $group_id;

    public $groups;

    public $task;

    public $title;

    public function addGroup(): void
    {
        $this->addGroupState = ! $this->addGroupState;
    }

    public function addTask(int $group_id): void
    {
        $this->group_id = $group_id;
    }

    public function deleteGroup(int $id): void
    {
        TrelloGroup::destroy($id);
    }

    public function deleteCard(int $id): void
    {
        TrelloCard::destroy($id);
    }

    public function messages()
    {
        return [
            'title.min' => __('The title field must be at least 3 characters.'),
        ];
    }

    public function saveGroup(): void
    {
        $data = $this->validate([
            'title' => 'required|min:3',
        ]);
        $data['user_id'] = auth()->user()->id;

        TrelloGroup::create($data);
        $this->reset();
    }

    public function saveTask(): void
    {
        $data = $this->validate([
            'task' => 'required|min:3',
        ]);
        $data['trello_group_id'] = $this->group_id;

        TrelloCard::create($data);
        $this->reset();
    }

    public function refreshGroups(): void
    {
        $this->groups = auth()->user()->trello_groups->sortBy('sort');
    }

    public function render()
    {
        $this->refreshGroups();

        return view('livewire.trello.trello');
    }

    public function updateOrder($groups)
    {
        // dd($groups);
        foreach ($groups as $group) {
            TrelloGroup::where(['id' => $group['value']])->update(['sort' => $group['order']]);

            if (isset($group['items'])) {
                foreach ($group['items'] as $item) {
                    TrelloCard::where(['id' => $item['value']])->update(['sort' => $item['order'], 'trello_group_id' => $group['value']]);
                }
            }
        }
    }
}

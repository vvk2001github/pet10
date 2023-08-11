<?php

namespace App\Http\Livewire\Feedback;

use App\Mail\FeedbackMail;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class FeedbackForm extends Component
{
    public $title = '';

    public $message = '';

    protected $rules = [
        'title' => 'required|min:5',
        'message' => 'required|min:5',
    ];

    public function messages()
    {
        return [
            'title.min' => __('The title field must be at least :num characters.', ['num' => '5']),
            'title.required' => __('The :value field is required.', ['value' => 'Заголовок']),
            'message.required' => __('The :value field is required.', ['value' => 'Сообщение']),
            'message.min' => __('The message field must be at least :num characters.', ['num' => '5']),
        ];
    }

    public function render()
    {
        return view('livewire.feedback.feedback-form');
    }

    public function send(): void
    {
        $data = $this->validate();
        $data['user_id'] = auth()->user()->id;
        $data['user_name'] = auth()->user()->name;
        $data['user_email'] = auth()->user()->email;

        Mail::to('support@example.com')->send(new FeedbackMail($data));

        $this->reset();
    }
}

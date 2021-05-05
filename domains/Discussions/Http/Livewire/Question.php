<?php

namespace Domains\Discussions\Http\Livewire;

use Domains\Discussions\DiscussionsServiceProvider;
use Domains\Discussions\Models\Question as QuestionModel;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Question extends Component
{
    public QuestionModel $question;
    public ?bool $editMode = false;
    protected $rules = [
        'question.title' => 'required|string|min:6',
        'question.description' => 'required|string|max:500',
    ];

    public function mount(QuestionModel $question): void
    {
        $this->question = $question;
    }

    public function render(): View
    {
        return view(DiscussionsServiceProvider::getName() . '::livewire.question');
    }

    public function edit(): void
    {
        $this->editMode = !$this->editMode;
    }

    public function cancelEdit(): void
    {
        $this->editMode = !$this->editMode;
        $this->question->refresh();
    }

    public function save(): void
    {
        if ($this->question->save()) {
            $this->editMode = false;
        }
    }
}

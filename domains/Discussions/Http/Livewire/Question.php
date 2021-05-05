<?php

namespace Domains\Discussions\Http\Livewire;

use Domains\Discussions\DiscussionsServiceProvider;
use Domains\Discussions\Models\Question as QuestionModel;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Question extends Component
{
    public ?QuestionModel $question;
    public ?bool $editMode = false;

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

    public function save(): void
    {
        $this->question->save();
    }
}

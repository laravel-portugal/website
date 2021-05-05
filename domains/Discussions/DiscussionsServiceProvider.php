<?php

namespace Domains\Discussions;

use App\Providers\BaseServiceProvider;
use Domains\Discussions\Http\Livewire\Question as QuestionComponent;
use Domains\Discussions\Http\Livewire\QuestionsIndex;
use Domains\Discussions\Models\Observers\QuestionObserver;
use Domains\Discussions\Models\Question;

class DiscussionsServiceProvider extends BaseServiceProvider
{
    protected array $observers = [
        Question::class => QuestionObserver::class,
    ];
    protected array $livewireComponents = [
        'questions-index' => QuestionsIndex::class,
        'question' => QuestionComponent::class,
    ];

    public static function getName(): string
    {
        return 'discussions';
    }
}

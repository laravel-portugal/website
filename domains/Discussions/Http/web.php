<?php

use Domains\Discussions\Http\Controllers\AnswersIndexController;
use Domains\Discussions\Http\Controllers\QuestionsViewController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth'], function () {
});

Route::view('discussions', 'discussions::questions-index')
    ->name('index');

Route::get('questions/{questionId}', [
    'as' => 'questions.view',
    'uses' => QuestionsViewController::class,
]);

Route::get('/questions/{questionId}/answers', [
    'as' => 'questions.answers.list',
    'uses' => AnswersIndexController::class,
]);

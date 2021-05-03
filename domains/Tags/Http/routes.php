<?php

use Domains\Tags\Http\Controllers\TagsIndexController;
use Illuminate\Support\Facades\Route;

Route::get('/tags', [
    'as' => 'index',
    'uses' => TagsIndexController::class,
]);

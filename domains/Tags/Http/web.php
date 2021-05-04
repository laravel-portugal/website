<?php

use Domains\Tags\Http\Controllers\TagsIndexController;
use Illuminate\Support\Facades\Route;

Route::get('/tags', TagsIndexController::class)
    ->name('index');

Route::get('/tag/{tag}/links', function () {
    return "<h1> trabalha malandro </h1>";
})->name('tag.links');


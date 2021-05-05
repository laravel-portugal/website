<?php

use Illuminate\Support\Facades\Route;

Route::get('/tag/{tag}/links', function () {
    return "<h1> trabalha malandro </h1>";
})->name('tag.links');


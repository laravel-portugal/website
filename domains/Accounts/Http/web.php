<?php

use Illuminate\Support\Facades\Route;

Route::get('/user/{username}/links', function () {
    return "<h1> trabalha malandro </h1>";
})->name('user.links');

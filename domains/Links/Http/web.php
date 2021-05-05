<?php

use Illuminate\Support\Facades\Route;

Route::view('/links', 'links::recent-links')
    ->name('index');

Route::view('/submit-link', 'links::submit-link')
    ->name('submit');


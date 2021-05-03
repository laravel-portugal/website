<?php

use Domains\Links\Http\Controllers\LinksStoreController;
use Illuminate\Support\Facades\Route;

Route::view('/links', 'links::submit-link')
    ->name('links');

Route::post('/links', [
    'as' => 'store',
    'uses' => LinksStoreController::class,
]);

<?php

use Illuminate\Support\Facades\Route;
use Spatie\Browsershot\Browsershot;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome-pre-2021');
});

Route::get('/welcome', function () {
    return view('welcome-2021');
})->name('home');

Route::get('/bs', function () {
    $foo = Browsershot::url('https://sapo.pt')
        ->noSandbox()
        ->format('a4')
        ->pdf();
    return response()->stream(function () use ($foo) {
        echo $foo;
    }, 200, ['Content-Type' => 'application/pdf']);
})->name('bs');

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

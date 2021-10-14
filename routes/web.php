<?php

use App\Http\Controllers\Backend\AdminLinksController;
use App\Http\Controllers\Frontend\CrawlerController;
use App\Http\Controllers\Frontend\DashboardController;
use App\Http\Controllers\Frontend\LinksController;
use App\Http\Controllers\Frontend\LinksRedirectController;
use App\Http\Controllers\Frontend\SocialLoginController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::view('/', 'welcome-pre-2021');

Route::get('landing', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

// Social Login
Route::get('login/{provider}/redirect', [SocialLoginController::class, 'redirect'])->name('social.redirect');
Route::get('login/{provider}/callback', [SocialLoginController::class, 'callback'])->name('social.callback');

// Redirect Controller
Route::get('/redirect/{link:hash}', [LinksRedirectController::class, 'redirect'])->name('links.redirect');

// Private Area for users
Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/crawler', [CrawlerController::class, 'search'])->name('crawler.search');
    Route::resource('links', LinksController::class)->middleware(['auth:sanctum', 'verified']);
});

// Private Area for Admins
Route::prefix('admin')
    ->as('admin.')
    ->middleware(['role:admin', 'auth:sanctum', 'verified'])
    ->group(function () {
        Route::get('/', function () { dd('im admin'); })->name('dashboard');
        Route::resource('links', AdminLinksController::class);
        Route::get('links/{link}/status/{status}', [AdminLinksController::class,'markAs'])->name('links.status');
    });

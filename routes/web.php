<?php

use App\Http\Controllers\Admin\AdminLinksController as AdminLinksController;
use App\Http\Controllers\Backend\CrawlerController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\LinksController as UserLinksController;
use App\Http\Controllers\Backend\SocialLoginController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\LinksController as LandingLinksController;
use App\Http\Controllers\Frontend\LinksRedirectController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Public routes
|--------------------------------------------------------------------------
*/

Route::view('/', 'welcome-pre-2021');

Route::get('/lander', [HomeController::class, 'index']);

Route::get('landing', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/links/redirect/{link:hash}', [LinksRedirectController::class, 'redirect'])->name('links.public.redirect');
Route::get('/links', [LandingLinksController::class, 'index'])->name('links.public');

/*
|--------------------------------------------------------------------------
| Social Login Auth
|--------------------------------------------------------------------------
*/
Route::get('login/{provider}/redirect', [SocialLoginController::class, 'redirect'])
    ->name('social.redirect')
    ->where('provider', implode('|', config('laravel-portugal.oauth-providers')));

Route::get('login/{provider}/callback', [SocialLoginController::class, 'callback'])
    ->name('social.callback')
    ->where('provider', implode('|', config('laravel-portugal.oauth-providers')));

/*
|--------------------------------------------------------------------------
| Users - Private Area Routes
|--------------------------------------------------------------------------
*/
Route::prefix('dashboard')->group(function () {
    Route::middleware(['auth:sanctum', 'verified'])->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::post('/crawler', [CrawlerController::class, 'search'])->name('crawler.search');
        Route::resource('links', UserLinksController::class)->middleware(['auth:sanctum', 'verified']);
        Route::put('links/{link}/restore', [UserLinksController::class, 'restore'])->withTrashed()->name('links.restore');
    });
});

/*
|--------------------------------------------------------------------------
| Admins & Moderators - Manage Links
|--------------------------------------------------------------------------
*/
Route::prefix('admin')
    ->as('admin.')
    ->middleware(['role:admin', 'auth:sanctum', 'verified'])
    ->group(function () {
        Route::get('/', function () { dd('im admin'); })->name('dashboard');
        Route::resource('links', AdminLinksController::class)->only(['index', 'edit', 'update', 'destroy']);
        Route::put('links/{link}/restore', [AdminLinksController::class, 'restore'])->withTrashed()->name('links.restore');
        Route::get('links/{link}/status/{status}', [AdminLinksController::class, 'markAs'])->name('links.status');
    });

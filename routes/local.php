<?php

/*
|--------------------------------------------------------------------------
| LOCAL routes. WARNING: NOT FOR PRODUCTION
|--------------------------------------------------------------------------
| This exposes some useful routes for Local & Development
| Thanks to Philo Hermans <@Philo01> for this poc
|
*/

use App\Models\User;

Route::get('/auto-login', function () {
    abort_unless(app()->environment('local'), 403);
    Auth::login(User::first());

    return redirect()->to(route('dashboard'));
});

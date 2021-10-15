<?php

use App\Providers\RouteServiceProvider;
use Laravel\Jetstream\Jetstream;

it('can render register screen', function () {
    $this->get(route('register'))->assertStatus(200);
});

it('can register new users', function () {
    $response = $this->post((route('register')), [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
        'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature(),
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(RouteServiceProvider::HOME);
});

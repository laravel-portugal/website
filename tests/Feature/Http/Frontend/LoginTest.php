<?php

use App\Models\User;
use App\Providers\RouteServiceProvider;

it('render login screen', function () {
    $response = $this->get(route('login'));
    // $response->assertStatus(200);
    $this->assertTrue(200 === $response->status(), $response->getContent());
});

it('user can login', function () {
    $user = User::factory()->create();

    $response = $this->post('/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(RouteServiceProvider::HOME);
});

it('user cannot login with invalid password', function () {
    $user = User::factory()->create();

    $this->post('/login', [
        'email' => $user->email,
        'password' => 'wrong-password',
    ]);

    $this->assertGuest();
});

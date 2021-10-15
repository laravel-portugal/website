<?php

use App\Models\User;

it('can render password confirmation screen', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get(route('password.confirm'));

    $response->assertStatus(200);
});

it('can confirm a password', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post(route('password.confirm'), [
        'password' => 'password',
    ]);

    $response->assertRedirect();
    $response->assertSessionHasNoErrors();
});

it('cannot confirm with invalid password', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post(route('password.confirm'), [
        'password' => 'wrong-password',
    ]);

    $response->assertSessionHasErrors();
});

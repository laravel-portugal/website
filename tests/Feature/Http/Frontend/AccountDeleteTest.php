<?php

use App\Models\User;
use Laravel\Jetstream\Features;

it('user can delete account', function () {
    if (! Features::hasAccountDeletionFeatures()) {
        return $this->markTestSkipped('Account deletion is not enabled.');
    }

    $this->actingAs($user = User::factory()->create());

    $this->delete('/user', [
        'password' => 'password',
    ]);

    $this->assertNotNull($user->fresh()->deleted_at);
});

it('user cannot delete without correct password', function () {
    if (! Features::hasAccountDeletionFeatures()) {
        return $this->markTestSkipped('Account deletion is not enabled.');
    }

    $this->actingAs($user = User::factory()->create());

    $response = $this->delete('/user', [
        'password' => 'wrong-password',
    ]);

    $this->assertNull($user->fresh()->deleted_at);
});

<?php

use App\Models\User;
use Laravel\Jetstream\Features;

it('can create api tokens', function () {
    if (! Features::hasApiFeatures()) {
        return $this->markTestSkipped('API support is not enabled.');
    }

    $this->actingAs($user = User::factory()->create());

    $response = $this->post('/user/api-tokens', [
        'name' => 'Test Token',
        'permissions' => [
            'read',
            'update',
        ],
    ]);

    $this->assertCount(1, $user->fresh()->tokens);
    $this->assertEquals('Test Token', $user->fresh()->tokens->first()->name);
    $this->assertTrue($user->fresh()->tokens->first()->can('read'));
    $this->assertFalse($user->fresh()->tokens->first()->can('delete'));
});

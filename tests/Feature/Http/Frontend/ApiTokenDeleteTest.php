<?php

use App\Models\User;
use Illuminate\Support\Str;
use Laravel\Jetstream\Features;

it('can delete api token', function () {
    if (! Features::hasApiFeatures()) {
        return $this->markTestSkipped('API support is not enabled.');
    }

    $this->actingAs($user = User::factory()->create());

    $token = $user->tokens()->create([
        'name' => 'Test Token',
        'token' => Str::random(40),
        'abilities' => ['create', 'read'],
    ]);

    $response = $this->delete('/user/api-tokens/'.$token->id);

    $this->assertCount(0, $user->fresh()->tokens);
});

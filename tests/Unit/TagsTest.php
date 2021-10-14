<?php

use App\Models\Tag;

it('can create tags', function () {
    Tag::factory()->count(10)->create();
    $this->assertDatabaseCount('tags', 10);
});

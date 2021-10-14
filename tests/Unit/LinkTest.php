<?php

use App\Models\Link;

it('can create links', function () {
    Link::factory()->count(10)->create();
    $this->assertDatabaseCount('links', 10);
});

it('can attach tags to links', function () {
    /** @var Link $link */
    $link = Link::factory()->withTags(10)->create();
    // Assert it has 10 taggable items
    $this->assertDatabaseCount('taggables', 10);
    // Assert it has 10 tags
    $this->assertDatabaseCount('tags', 10);
    // Assert link has exactly 10 tags on the collection
    $this->assertSame($link->getTags()->count(), 10);
});

it('can detach tags from links', function () {
    /** @var Link $link */
    $link = Link::factory()->withTags(10)->create();
    $link->removeTags();
    // Assert link has exactly 10 tags on the collection
    $this->assertSame($link->getTags()->count(), 0);
});

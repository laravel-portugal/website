<?php

use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\UploadedFile;

it('render links create screen', function () {
    $this->actingAs($user = User::factory()->create());
    $response = $this->get(route('links.create'));
    $response->assertOk();
});

it('can create new links', function () {

    $this->actingAs($user = User::factory()->create());

    $response = $this->post(route('links.store'), [
        'url' => 'https://laravel.com',
        'title' => 'This is a test link',
        'description' => 'This is a test description of something with a minimum of the size',
        'cover_image' => UploadedFile::fake()->image('cover_image.jpg'),
        'tags' => Tag::factory()->count(2)->create()->pluck('id')->toArray()
    ]);

    $this->assertDatabaseHas('links',[
        'url' => 'https://laravel.com',
        'title' => 'This is a test link',
    ]);
});

it('cannot update if status is waiting approval', function () {
    return $this->markTestSkipped('Not yet implemented');
});

it('cannot insert same link twice', function () {
    return $this->markTestSkipped('Not yet implemented');
});

it('can crawl links', function () {
    return $this->markTestSkipped('Not yet implemented');
});

it('can list links', function () {
    return $this->markTestSkipped('Not yet implemented');
});

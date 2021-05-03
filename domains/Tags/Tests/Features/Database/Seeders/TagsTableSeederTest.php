<?php

namespace Domains\Tags\Tests\Features\Database\Seeders;

use Domains\Tags\Database\Seeders\TagsTableSeeder;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class TagsTableSeederTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_seeds_tags_table(): void
    {
        $this->artisan('db:seed', ['--class' => TagsTableSeeder::class]);

        $this->assertDatabaseHas('tags', ['name' => 'Eloquent'])
            ->assertDatabaseHas('tags', ['name' => 'Livewire'])
            ->assertDatabaseHas('tags', ['name' => 'Vue'])
            ->assertDatabaseHas('tags', ['name' => 'Testing']);
    }
}

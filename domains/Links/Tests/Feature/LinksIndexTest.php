<?php

namespace Domains\Links\Tests\Feature;

use Domains\Links\Database\Factories\LinkFactory;
use Domains\Links\Http\Livewire\RecentLinks;
use Domains\Links\Models\Link;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Livewire\Livewire;
use Tests\TestCase;

class LinksIndexTest extends TestCase
{
    use DatabaseMigrations;

    const DUMMY_LINKS = 20;

    protected function setUp(): void
    {
        parent::setUp();

        LinkFactory::times(self::DUMMY_LINKS)->approved()->create();
    }

    /** @test */
    public function it_lists_resources(): void
    {
        Livewire::test(RecentLinks::class)
            ->assertCount('links', min((new Link())->getPerPage(), self::DUMMY_LINKS));
    }

    /** @test */
    public function it_includes_tags_relation(): void
    {
        $links = Livewire::test(RecentLinks::class)
            ->get('links');

        self::assertCount(1, $links[0]['tags']);
    }
}

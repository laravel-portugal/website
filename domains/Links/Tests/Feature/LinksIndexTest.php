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
            ->assertSee(Link::all()[rand(0,self::DUMMY_LINKS)]->title);
    }

    /** @test */
    public function it_includes_tags_relation(): void
    {
        $response = $this->get('/links?include=tags')
            ->assertJsonStructure([
                'data' => [
                    [
                        'tags',
                    ],
                ],
            ]);

        $response->assertOk();

        self::assertCount(1, $response->json()['data'][0]['tags']);
    }

    /** @test */
    public function it_doesnt_include_relations_if_not_required(): void
    {
        $response = $this->get('/links');

        $response->assertOk();

        self::assertArrayNotHasKey('tags', $response->json()['data'][0]);
    }

    /** @test */
    public function it_supports_pagination_navigation(): void
    {
        $response = $this->get('/links?page=2');

        $response->assertOk();

        self::assertEquals(2, $response->json()['meta']['current_page']);
    }
}

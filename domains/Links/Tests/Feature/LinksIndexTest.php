<?php

namespace Domains\Links\Tests\Feature;

use Domains\Links\Database\Factories\LinkFactory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class LinksIndexTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();

        LinkFactory::times(20)->approved()->create();
    }

    /** @test */
    public function it_lists_resources(): void
    {
        $this->get('/links')
            ->assertJsonStructure([
                'data' => [
                    [
                        'id',
                        'link',
                        'title',
                        'description',
                        'cover_image',
                        'author_name',
                        'author_email',
                        'created_at',
                    ],
                ],
                'links' => [
                    'first',
                    'last',
                    'prev',
                    'next',
                ],
            ])
            ->assertOk();
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

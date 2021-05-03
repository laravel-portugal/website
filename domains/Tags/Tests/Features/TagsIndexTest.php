<?php

namespace Domains\Tags\Tests\Features;

use Domains\Tags\Database\Factories\TagFactory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class TagsIndexTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();

        TagFactory::times(2)->create();
    }

    /** @test */
    public function it_lists_all_resources(): void
    {
        $response = $this->get('/tags')
            ->assertJsonStructure([
                'data' => [
                    [
                        'id', 'name', 'created_at',
                    ],
                ],
            ]);

        $response->assertOk();

        self::assertCount(2, $response->json()['data']);
    }
}

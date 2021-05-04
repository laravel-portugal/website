<?php

namespace Domains\Tags\Tests\Unit;

use Domains\Tags\Database\Factories\TagFactory;
use Domains\Tags\Services\TagsIndexService;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class TagsIndexServiceTest extends TestCase
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
        $tags = (new TagsIndexService())();

        self::assertCount(2, $tags);
    }
}

<?php

namespace Domains\Links\Tests\Feature;

use Database\Factories\UserFactory;
use Domains\Accounts\Enums\AccountTypeEnum;
use Domains\Links\Database\Factories\LinkFactory;
use Domains\Links\Http\Livewire\SubmitLink;
use Domains\Tags\Database\Factories\TagFactory;
use Domains\Tags\Models\Tag;
use Faker\Factory;
use Faker\Generator;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class LinksStoreLimitTest extends TestCase
{
    use DatabaseMigrations;

    protected Generator $faker;
    protected string $authorEmail;
    protected Tag $tag;
    protected int $limit;
    protected array $payload;
    protected array $files;

    public function unrestrictedUserRolesProvider(): array
    {
        return [
            'Editor Role' => [AccountTypeEnum::EDITOR],
            'Admin Role' => [AccountTypeEnum::ADMIN],
        ];
    }

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('local');

        $this->faker = Factory::create();
        $this->authorEmail = $this->faker->safeEmail;
        $this->tag = TagFactory::new()->create();

        // set a random limit
        $this->limit = $this->faker->numberBetween(1, 10);
        config(['links.max_unapproved_links' => $this->limit]);

        // create $limit number of Links
        LinkFactory::times($this->limit)
            ->withAuthorEmail($this->authorEmail)
            ->create();

        // prepare the requests' payload and files
        $this->files = [
            'cover_image' => UploadedFile::fake()->image('cover_image.jpg'),
        ];
        $this->payload = [
            'link' => $this->faker->url,
            'title' => $this->faker->title,
            'description' => $this->faker->paragraph,
            'author_name' => $this->faker->name,
            'author_email' => $this->authorEmail,
            'tags' => [$this->tag->id],
            'photo' => $this->files['cover_image'],
        ];
    }

    /** @test */
    public function it_fails_to_store_links_when_exceeding_unapproved_limit(): void
    {
        Livewire::test(SubmitLink::class)
            ->set($this->payload)
            ->call('submit');

        // no new Link was created.
        $this->assertDatabaseCount('links', $this->limit);
    }

    /** @test */
    public function it_stores_links_above_unapproved_limit_when_from_another_author(): void
    {
        // use another author_email
        $this->payload['author_email'] = $this->faker->safeEmail;

        Livewire::test(SubmitLink::class)
            ->set($this->payload)
            ->call('submit');

        // 1 new Link was created.
        $this->assertDatabaseCount('links', $this->limit + 1);
    }

    /** @test */
    public function it_stores_links_above_unapproved_limit_when_user_is_trusted(): void
    {
        $this->actingAs(UserFactory::new()->trusted()->make());

        Livewire::test(SubmitLink::class)
            ->set($this->payload)
            ->call('submit');

        $this->assertDatabaseCount('links', $this->limit + 1);
    }

    /**
     * @test
     * @dataProvider unrestrictedUserRolesProvider
     *
     * @param string $role
     */
    public function it_stores_links_above_unapproved_limit_when_user_has_unrestricted_role(string $role): void
    {
        $this->actingAs(UserFactory::new()->withRole($role)->make());

        Livewire::test(SubmitLink::class)
            ->set($this->payload)
            ->call('submit');

        $this->assertDatabaseCount('links', $this->limit + 1);
    }
}

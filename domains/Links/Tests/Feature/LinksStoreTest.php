<?php

namespace Domains\Links\Tests\Feature;

use Domains\Accounts\Database\Factories\UserFactory;
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

class LinksStoreTest extends TestCase
{
    use DatabaseMigrations;

    private Tag $tag;
    private Generator $faker;
    private array $payload;
    private array $files;

    protected function setUp(): void
    {
        parent::setUp();

        $this->tag = TagFactory::new()->create();
        $this->faker = Factory::create();

        $this->files = [
            'cover_image' => UploadedFile::fake()->image('cover_image.jpg'),
        ];
        $this->payload = [
            'website' => $this->faker->url,
            'title' => $this->faker->title,
            'description' => $this->faker->paragraph,
            'author_name' => $this->faker->name,
            'author_email' => $this->faker->safeEmail,
            'tags' => [$this->tag->id],
            'photo' => $this->files['cover_image'],
        ];

        Storage::fake('public');
    }

    /** @test */
    public function it_stores_resources(): void
    {
        Livewire::test(SubmitLink::class)
            ->set($this->payload)
            ->call('submit');

        $this->assertDatabaseHas('links', [
            'link' => $this->payload['website'],
            'title' => $this->payload['title'],
            'description' => $this->payload['description'],
            'author_name' => $this->payload['author_name'],
            'author_email' => $this->payload['author_email'],
            'approved_at' => null,
        ]);

        $this->assertDatabaseHas(
            'link_tag',
            [
                'tag_id' => $this->tag->id,
            ]
        );
    }

    /** @test */
    public function it_fails_to_store_resources_on_validation_errors(): void
    {
        Livewire::test(SubmitLink::class)
            ->call('submit')
            ->assertHasErrors([
                'website',
                'author_name',
            ]);
    }

    /** @test */
    public function it_fails_to_store_resources_with_invalid_link(): void
    {
        $this->payload['website'] = 'some_invalid_url';

        Livewire::test(SubmitLink::class)
            ->set($this->payload)
            ->call('submit')
            ->assertHasErrors(['website']);
    }

    /** @test */
    public function it_stores_resources_with_unregistered_link_domain(): void
    {
        $this->payload['website'] = 'http://unregistered.laravel.pt';

        Livewire::test(SubmitLink::class)
            ->set($this->payload)
            ->call('submit')
            ->assertHasNoErrors();
    }

    /** @test */
    public function it_forbids_guest_to_use_a_registered_users_email_when_submitting_a_link(): void
    {
        $user = UserFactory::new(['email' => $this->faker->safeEmail])
            ->create();

        $this->payload['author_email'] = $user->email;

        Livewire::test(SubmitLink::class)
            ->set($this->payload)
            ->call('submit');

        $this->assertDatabaseCount('links', 0);
    }

    /** @test */
    public function it_uses_logged_in_user_email_and_name_when_submitting_a_link(): void
    {
        // create a random user
        $randomUser = UserFactory::new(['email' => $this->faker->safeEmail])->create();
        // create a user and login
        $user = UserFactory::new(['email' => $this->faker->safeEmail])->create();
        $this->actingAs($user);

        // use an existing user's email and it should go OK since we're logged in.
        $this->payload['author_email'] = $randomUser->email;

        Livewire::test(SubmitLink::class)
            ->set($this->payload)
            ->call('submit');

        $this->assertDatabaseHas(
            'links',
            [
                'author_email' => $user->email,
                'author_name' => $user->name,
            ]
        );
    }
}

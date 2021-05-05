<?php

namespace Domains\Discussions\Tests\Feature;

use App\Models\User;
use Domains\Accounts\Database\Factories\UserFactory;
use Faker\Factory;
use Faker\Generator;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Tests\TestCase;

class QuestionsStoreTest extends TestCase
{
    use DatabaseMigrations;

    private Generator $faker;
    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->faker = Factory::create();
        $this->user = UserFactory::new()->create();
    }

    /** @test */
    public function it_stores_questions(): void
    {
        $payload = [
            'title' => $this->faker->title,
            'description' => $this->faker->paragraph,
        ];

        $response = $this->actingAs($this->user)
            ->call('POST', route('discussions.questions.store'), $payload)
            ->assertStatus(Response::HTTP_NO_CONTENT);

        self::assertTrue($response->isEmpty());

        $this->seeInDatabase('questions', [
            'author_id' => $this->user->id,
            'title' => $payload['title'],
            'description' => $payload['description'],
            'slug' => Str::slug($payload['title']),
        ]);
    }

    /** @test */
    public function it_forbids_guests_to_store_questions(): void
    {
        $this->post(route('discussions.questions.store'))
            ->assertResponseStatus(Response::HTTP_UNAUTHORIZED);
    }

    /** @test */
    public function it_fails_to_store_questions_on_validation_errors(): void
    {
        $this->actingAs($this->user)
            ->post(route('discussions.questions.store'))
            ->seeJsonStructure([
                'title',
                'description',
            ]);
    }
}

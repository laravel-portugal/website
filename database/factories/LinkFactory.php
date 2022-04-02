<?php

namespace Database\Factories;

use App\Models\Link;
use App\Models\Tag;
use App\Models\User;
use App\Types\LinkStatusType;
use Hashids\Hashids;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class LinkFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => $attributes['user_id'] ?? User::factory(),
            'hash' => (new Hashids())->encode(time(), crc32(Str::random(10))),
            'url' => $this->faker->url(),
            'title' => $this->faker->realText(30),
            'description' => $this->faker->text(50),
            'status' => $this->faker->randomKey(LinkStatusType::toArray()),
            // 'cover_image' => $this->faker->image('public/dummy')
            'cover_image' => Storage::disk(Link::coverPhotosDisk())->putFile(Link::coverPhotosFolder(), $this->faker->file(resource_path('/img/dummy'))),
//            'cover_image' => $this->faker->image(
//                //Storage::disk(Link::coverPhotosDisk())->path(Link::coverPhotosFolder()),
//                storage_path(Link::coverPhotosFolder()),
//                config('laravel-portugal.links.cover_image.size.w'),
//                config('laravel-portugal.links.cover_image.size.h')
//            )
        ];
    }

    public function withTags($count = 5)
    {
        return $this->has(Tag::factory()->count($count), 'tags');
    }

    public function withExistingTags($count = 5)
    {
        return $this->hasAttached(
            Tag::query()
                ->inRandomOrder()
                ->take($this->faker->numberBetween(1, $count))
                ->get()
        );
    }

    public function published()
    {
        return $this->state([
            'status' => LinkStatusType::published(),
            'approved_at' => now(),
        ]);
    }

    public function waiting_approval()
    {
        return $this->state([
            'status' => LinkStatusType::waiting_approval(),
            'approved_at' => null,
        ]);
    }

    public function rejected()
    {
        return $this->state([
            'status' => LinkStatusType::rejected(),
            'rejected_at' => now(),
        ]);
    }
}

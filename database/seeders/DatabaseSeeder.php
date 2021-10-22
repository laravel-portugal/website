<?php

namespace Database\Seeders;

use App\Models\Link;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Create a dummy admin
        $this->createAdmin();

        // Create 10 users
        User::factory(2)->create();

        Tag::factory()
            ->count(11)
            ->state(new Sequence(
                ['name' => 'Laravel'],
                ['name' => 'Eloquent'],
                ['name' => 'Inertia'],
                ['name' => 'Livewire'],
                ['name' => 'Database'],
                ['name' => 'Hacks'],
                ['name' => 'Tips'],
                ['name' => 'Routes'],
                ['name' => 'Requests'],
                ['name' => 'Middleware'],
                ['name' => 'Migrations'],
                ['name' => 'Packages'],
            ))
            ->create();

        // 10 links with 10 tags each
        Link::factory()
            ->withExistingTags()
            ->count(10)
            ->create();
    }

    protected function createAdmin()
    {
        if(!User::whereEmail('admin@admin.com')){
            /* @var User $user */
            User::factory()->state([
                'name' => 'The Boss',
                'email' => 'admin@admin.com',
            ])->create()->assignRole('admin');
        }
    }
}

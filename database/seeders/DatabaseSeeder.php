<?php

namespace Database\Seeders;

use Domains\Links\Database\Seeders\LinksTableSeeder;
use Exception;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     * @throws Exception
     */
    public function run()
    {
        if ($this->container['config']->get('app.env') === 'production') {
            throw new Exception('This is not allowed when in production environment.');
        }

        $this->call(LinksTableSeeder::class);
    }
}

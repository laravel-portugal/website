<?php

namespace Domains\Discussions\Database\Seeders;

use Domains\Discussions\Database\Factories\AnswerFactory;
use Illuminate\Database\Seeder;

class AnswersTableSeeder extends Seeder
{
    public function run(): void
    {
        AnswerFactory::times(20)
            ->create();
    }
}

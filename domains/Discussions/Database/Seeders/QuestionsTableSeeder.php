<?php

namespace Domains\Discussions\Database\Seeders;

use Domains\Discussions\Database\Factories\QuestionFactory;
use Illuminate\Database\Seeder;

class QuestionsTableSeeder extends Seeder
{
    public function run(): void
    {
        QuestionFactory::times(20)
            ->create();
    }
}

<?php

namespace App\Console\DevelopmentCommands;

use Illuminate\Console\Command;
use Illuminate\Console\OutputStyle;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class BaseDevelopmentCommand extends Command
{
    /**
     * Run the console command.
     *
     * @return int
     */
    public function run(InputInterface $input, OutputInterface $output)
    {
        if (app()->environment('production')) {
            $this->error('This command can only be ran in Development Environment. WTF you doing');

            return;
        }

        $this->output = $this->laravel->make(
            OutputStyle::class,
            ['input' => $input, 'output' => $output]
        );

        return parent::run(
            $this->input = $input,
            $this->output
        );
    }
}

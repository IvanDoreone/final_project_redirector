<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Cube extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cube:cube {num}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'make numm**3';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $argument1 = $this->argument('num');
        echo ($argument1**3);
    }
}

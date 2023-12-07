<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class crew extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:crew {$a}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $b = $this->argument('$a');
        echo($b);
    }
}

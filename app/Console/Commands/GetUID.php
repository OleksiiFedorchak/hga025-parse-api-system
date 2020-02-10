<?php

/**
 * Class namespace
 */
namespace App\Console\Commands;

/**
 * Used packages
 */

use App\Jobs\ProcessOdds;
use Illuminate\Console\Command;

/**
 * Class for processing data with Hga025
 *
 * Class GetUID
 * @package App\Console\Commands
 */
class GetUID extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'process:odds';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get uid for sending requests';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Start process..');
        ProcessOdds::dispatch()->onQueue('processing');
        $this->info('dispatched..');
    }
}

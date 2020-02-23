<?php

/**
 * Class namespace
 */
namespace App\Console\Commands;

/**
 * Used packages
 */

use App\Jobs\ProcessOdds;
use App\Tools\HgaClient;
use App\Tools\HgaConnector;
use App\Tools\Settings\SportTypes;
use App\Traits\Processors;
use Illuminate\Console\Command;

/**
 * Class for processing data with Hga025
 *
 * Class GetUID
 * @package App\Console\Commands
 */
class GetUID extends Command
{
    use Processors;
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

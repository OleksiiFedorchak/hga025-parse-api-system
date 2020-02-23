<?php

/**
 * Class namespace
 */
namespace App\Console\Commands;

/**
 * Used packages
 */
use App\Jobs\ProcessSpecificMatch;
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
        $this->info('Running processors');
        try {
            $connector = (new HgaConnector())->setConnection()->save();
            $hgaClient = new HgaClient($connector);

            foreach (collect($hgaClient->matches())->chunk(25) as $chunkedMatches) {

                $counter = 1;
                foreach ($chunkedMatches as $key => $matchId) {
                    ProcessSpecificMatch::dispatch($connector->uid(), SportTypes::BASKETBALL, false, $matchId)
                        ->onQueue('p' . $counter);

                    $counter++;
                }
            }

            sleep(15);
            $this->call('process:odds');
        } catch (\Exception $e) {
            $this->info('Server falling.. Retry in fifteen seconds..');
            sleep(15);

            $this->call('process:odds');
        }
    }
}

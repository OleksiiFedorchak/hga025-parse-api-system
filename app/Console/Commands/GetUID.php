<?php

/**
 * Class namespace
 */
namespace App\Console\Commands;

/**
 * Used packages
 */

use App\Jobs\ProcessOdds;
use App\Match;
use App\Tools\HgaClient;
use App\Tools\HgaConnector;
use App\Tools\HgaGetter;
use Illuminate\Console\Command;
use App\Tools\Settings\SportTypes;

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

//        $connector = (new HgaConnector())->setConnection()->save();
//        $hgaClient = new HgaClient($connector);
//
//        $this->process($hgaClient, SportTypes::SOCCER, false);
//        $this->process($hgaClient, SportTypes::BASKETBALL, false);
    }

//    /**
//     * process specific case
//     *
//     * @param HgaClient $hgaClient
//     * @param string $sportType
//     * @param bool $isLive
//     */
//    private function process(HgaClient $hgaClient, string $sportType, bool $isLive)
//    {
//        foreach ($hgaClient->matches($sportType, $isLive) as $matchId) {
//            $this->info('Processing match: ' . $matchId);
//            $matchModel = new Match();
//            $matchClient = $hgaClient->match($matchId, $sportType, $isLive);
//            $matchGetter = new HgaGetter($matchClient);
//
//            $matchModel
//                ->set($matchGetter, ['match_id' => $matchId, 'sport_type' => $sportType, 'is_live' => $isLive])
//                ->save();
//        }
//    }
}

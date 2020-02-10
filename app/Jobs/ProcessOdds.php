<?php

/**
 * Class namespace
 */
namespace App\Jobs;

/**
 * Used packages
 */

use App\Match;
use App\Packages\ContactUs\Http\Requests\ValidateCreateContactUsMessage;
use App\Tools\HgaClient;
use App\Tools\HgaConnector;
use App\Tools\HgaGetter;
use App\Tools\Settings\SportTypes;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

/**
 * Class-job for processing ods
 *
 * Class ProcessOdds
 * @package App\Jobs
 */
class ProcessOdds implements ShouldQueue
{
    /**
     * traits..
     */
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $connector = (new HgaConnector())->setConnection()->save();
        $hgaClient = new HgaClient($connector);

        try {
            if (!empty(env('CURRENT_TRACKING_MATCH'))) {
                $this->processSpecificMatch($hgaClient, SportTypes::SOCCER, false, env('CURRENT_TRACKING_MATCH'));
            } else {
                $this->process($hgaClient, SportTypes::SOCCER, false);
                $this->process($hgaClient, SportTypes::BASKETBALL, false);
            }
        } catch (\Exception $e) {
            try {
                $connector->refreshConnection();
                $hgaClient = new HgaClient($connector);

                if (!empty(env('CURRENT_TRACKING_MATCH'))) {
                    $this->processSpecificMatch($hgaClient, SportTypes::SOCCER, false, env('CURRENT_TRACKING_MATCH'));
                } else {
                    $this->process($hgaClient, SportTypes::SOCCER, false);
                    $this->process($hgaClient, SportTypes::BASKETBALL, false);
                }
            } catch (\Exception $e) {}
        }

        self::dispatch()->onQueue('processing');
    }

    /**
     * process specific case
     *
     * @param HgaClient $hgaClient
     * @param string $sportType
     * @param bool $isLive
     */
    private function process(HgaClient $hgaClient, string $sportType, bool $isLive)
    {
        foreach ($hgaClient->matches($sportType, $isLive) as $matchId) {
            try {
                $matchModel = new Match();
                $matchClient = $hgaClient->match($matchId, $sportType, $isLive);
                $matchGetter = new HgaGetter($matchClient);

                $matchModel
                    ->set($matchGetter, ['match_id' => $matchId, 'sport_type' => $sportType, 'is_live' => $isLive])
                    ->save();
            } catch (\Exception $e) {}
        }
    }

    /**
     * process specific match
     *
     * @param HgaClient $hgaClient
     * @param string $sportType
     * @param bool $isLive
     * @param int $matchId
     */
    private function processSpecificMatch(HgaClient $hgaClient, string $sportType, bool $isLive, int $matchId)
    {
        try {
            $matchModel = new Match();
            $matchClient = $hgaClient->match($matchId, $sportType, $isLive);
            $matchGetter = new HgaGetter($matchClient);

            $matchModel
                ->set($matchGetter, ['match_id' => $matchId, 'sport_type' => $sportType, 'is_live' => $isLive])
                ->save();
        } catch (\Exception $e) {}
    }
}

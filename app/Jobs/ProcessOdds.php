<?php

/**
 * Class namespace
 */
namespace App\Jobs;

/**
 * Used packages
 */
use App\Tools\HgaClient;
use App\Tools\HgaConnector;
use App\Tools\Settings\SportTypes;
use App\Traits\Processors;
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
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, Processors;

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
}

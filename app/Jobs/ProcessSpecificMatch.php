<?php

/**
 * Class namespace
 */
namespace App\Jobs;

/**
 * Used packages
 */
use App\Tools\HgaClient;
use App\Traits\Processors;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

/**
 * Class-job for processing specific match
 *
 * Class ProcessSpecificMatch
 * @package App\Jobs
 */
class ProcessSpecificMatch implements ShouldQueue
{
    /**
     * A few amazing lara traits..
     */
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, Processors;

    /**
     * client instance
     *
     * @var HgaClient
     */
    protected $hgaClient;

    /**
     * sport type
     *
     * @var string
     */
    protected $sportType;

    /**
     * is match live
     *
     * @var bool
     */
    protected $isLive;

    /**
     * match id in hga025 system
     *
     * @var int
     */
    protected $matchId;

    /**
     * create processor instance
     *
     * ProcessSpecificMatch constructor.
     * @param HgaClient $hgaClient
     * @param string $sportType
     * @param bool $isLive
     * @param string $matchId
     */
    public function __construct(HgaClient $hgaClient, string $sportType, bool $isLive, string $matchId)
    {
        $this->hgaClient = $hgaClient;
        $this->sportType = $sportType;
        $this->isLive = $isLive;
        $this->matchId = $matchId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->processSpecificMatchByGuzzle($this->hgaClient, $this->sportType, $this->isLive, $this->matchId);
    }
}

<?php

/**
 * Trait namespace
 */
namespace App\Traits;

/**
 * Used packages
 */

use App\Jobs\ProcessSpecificMatch;
use App\Match;
use App\Tools\HgaClient;
use App\Tools\HgaGetter;
use App\Tools\HgaGuzzleGetter;
use SimpleXMLElement;

/**
 * Processors trait
 *
 * Trait Processors
 * @package App\Traits
 */
trait Processors
{
    /**
     * process all matches without any jobs just step by step
     *
     * @param HgaClient $hgaClient
     * @param string $sportType
     * @param bool $isLive
     */
    public function process(HgaClient $hgaClient, string $sportType, bool $isLive)
    {
        foreach ($hgaClient->matches($sportType, $isLive) as $matchId)
            ProcessSpecificMatch::dispatch($hgaClient, (string) $sportType, (bool) $isLive, (int) $matchId)
                ->onQueue('processing');
    }

    /**
     * process specific match without any jobs | just one match again and again
     *
     * @param HgaClient $hgaClient
     * @param string $sportType
     * @param bool $isLive
     * @param string $matchId
     */
    public function processSpecificMatch(HgaClient $hgaClient, string $sportType, bool $isLive, string $matchId)
    {
        $matchModel = new Match();
        $matchClient = $hgaClient->match($matchId, $sportType, $isLive);
        $matchGetter = new HgaGetter($matchClient);

        $matchModel
            ->set($matchGetter, ['match_id' => $matchId, 'sport_type' => $sportType, 'is_live' => $isLive])
            ->save();
    }

    /**
     * process specific match without any jobs | just one match again and again | using Guzzle -> only for jobs executions
     *
     * @param HgaClient $hgaClient
     * @param string $sportType
     * @param bool $isLive
     * @param string $matchId
     */
    public function processSpecificMatchByGuzzle(HgaClient $hgaClient, string $sportType, bool $isLive, string $matchId)
    {
        $matchModel = new Match();
        $matchClient = $hgaClient->matchByGuzzle($matchId, $sportType, $isLive);
        $matchGetter = new HgaGuzzleGetter(new SimpleXMLElement($matchClient));

        $matchModel
            ->set($matchGetter, ['match_id' => $matchId, 'sport_type' => $sportType, 'is_live' => $isLive])
            ->save();
    }
}

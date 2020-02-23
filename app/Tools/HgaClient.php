<?php

/**
 * Class namespace
 */
namespace App\Tools;

/**
 * Used packages
 */

use App\Tools\Settings\SportTypes;
use Goutte\Client;
use GuzzleHttp\Client as GuzzleClient;
use Carbon\Carbon;
use Symfony\Component\DomCrawler\Crawler;

/**
 * HgaClient for specific game
 *
 * Class HgaClient
 * @package App\Tools
 */
class HgaClient
{
    /**
     * @var HgaConnector
     */
    protected $connector;

    /**
     * Goutte client instance
     *
     * @var Client
     */
    protected $client;

    /**
     * Guzzle is necessary because Goutte is not working in job mode
     *
     * @var GuzzleClient
     */
    protected $guzzleClient;

    /**
     * Construct new instance
     *
     * HgaClient constructor.
     * @param HgaConnector $connector
     */
    public function __construct(HgaConnector $connector)
    {
        $this->connector = $connector;
        $this->client = new Client();
        $this->guzzleClient = new GuzzleClient();
    }

    /**
     * get client for specific url
     *
     * @param string $gid
     * @param string $sportType
     * @param bool $isLive
     * @return Crawler
     */
    public function match(string $gid, string $sportType = SportTypes::BASKETBALL, bool $isLive = false)
    {
        $urlData = [
            'uid' => $this->connector->uid(),
            'gid' => $gid,
            'date' => Carbon::now()->format('Y-m-d'),
        ];

        return $this->client->request('GET', DataSettings::url($urlData, $sportType, $isLive))
            ->filter('#gid' . $gid)
            ->first();
    }

    /**
     * get match using Guzzle
     *
     * @param string $gid
     * @param string $sportType
     * @param bool $isLive
     * @return string
     */
    public function matchByGuzzle(string $gid, string $sportType = SportTypes::BASKETBALL, bool $isLive = false)
    {
        $urlData = [
            'uid' => $this->connector->uid(),
            'gid' => $gid,
            'date' => Carbon::now()->format('Y-m-d'),
        ];

        return $this->guzzleClient->request('GET', DataSettings::url($urlData, $sportType, $isLive))
            ->getBody()
            ->getContents();
    }

    /**
     * get matches ids
     *
     * @param bool $isLive
     * @param string $sportType
     * @return array
     */
    public function matches(string $sportType = SportTypes::BASKETBALL, bool $isLive = false)
    {
        $nodes = $this
            ->client
            ->request('GET',
                DataSettings::matchesListUrl($this->connector->uid(), $sportType, $isLive)
            );

        return collect(
            $nodes->each(function ($node) use ($isLive) {
                $data = $node->text();

                $ids = [];
                foreach (explode(DataSettings::MATCHES_EXPLODE_DELIMETER, $data) as $explodedNode)
                    if (strpos($explodedNode, $isLive ? DataSettings::MATCHES_IDS_IDENTIFIER_LIVE : DataSettings::MATCHES_IDS_IDENTIFIER) !== FALSE) {
                        if (!$isLive) {
                            $ids[] = str_replace(DataSettings::MATCHES_IDS_IDENTIFIER, '', $explodedNode);
                            continue;
                        }

                        $ids[] = explode(DataSettings::MATCHES_IDS_IDENTIFIER_LIVE, $explodedNode)[1];
                    }

                return $ids;
            })
        )->first();
    }
}

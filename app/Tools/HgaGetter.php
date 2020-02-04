<?php

/**
 * Class namespace
 */
namespace App\Tools;

/**
 * Used packages
 */
use Symfony\Component\DomCrawler\Crawler;

/**
 * Class for getting special data
 *
 * Class HgaGetter
 * @package App\Tools
 */
class HgaGetter
{
    /**
     * Goutte Client instance
     *
     * @var Crawler
     */
    protected $client;

    /**
     * Bring him to life..
     *
     * HgaGetter constructor.
     * @param Crawler $client
     */
    public function __construct(Crawler $client)
    {
        $this->client = $client;
    }

    /**
     * Let the magic arrive..
     *
     * @param $name
     * @param $arguments
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        return $this->client
            ->filter($name)
            ->first()
            ->text();
    }
}

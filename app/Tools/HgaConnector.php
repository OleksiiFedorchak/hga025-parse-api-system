<?php

/**
 * Class namespace
 */
namespace App\Tools;

/**
 * Used packages
 */

use App\Connection;
use App\Tools\Settings\LoginSettings;
use Goutte\Client;

/**
 * Class for setting connections and data with Hga025
 *
 * Class HgaClient
 * @package App\Tools\Settings
 */
class HgaConnector
{
    /**
     * Goutte client for getting data from hga025
     *
     * @var Client
     */
    protected $client;

    /**
     * Current user uid
     *
     * @var string
     */
    protected $uid;

    /**
     * refresh connection
     *
     * @return $this
     */
    public function refreshConnection()
    {
        $client = new Client();
        $crawler = $client->request('GET', LoginSettings::url());

        $data = collect(
            $crawler
                ->filter('body > p')
                ->each(function ($node) {
                    return $node->text();
                }))
            ->first();

        $this->uid = explode('|', $data)[3] ?? null;
        return $this;
    }

    /**
     * get uid
     *
     * @return string
     */
    public function uid()
    {
        return $this->uid;
    }

    /**
     * save connection to db
     */
    public function save()
    {
        Connection::create([
            'uid' => $this->uid,
        ]);

        return $this;
    }

    /**
     * take old or refresh connection..
     */
    public function setConnection()
    {
        $this->uid = Connection::get()->uid ?? null;
        if (is_null($this->uid))
            return $this->refreshConnection();

        return $this;
    }
}

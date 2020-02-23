<?php

/**
 * Class namespace
 */
namespace App\Tools;

/**
 * Used packages
 */
use SimpleXMLElement;

/**
 * Class for getting special data
 *
 * Class HgaGuzzleGetter
 * @package App\Tools
 */
class HgaGuzzleGetter implements Getter
{
    /**
     * Simple xml instance item
     *
     * @var SimpleXMLElement
     */
    protected $xml;

    /**
     * Bring him to life..
     *
     * HgaGuzzleGetter constructor.
     * @param SimpleXMLElement $xml
     */
    public function __construct(SimpleXMLElement $xml)
    {
        $this->xml = $xml;
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
        return (string) $this->xml[0]->children()->game[0]->$name;
    }
}

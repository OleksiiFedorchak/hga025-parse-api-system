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
        $name = $this->transformName($name);
        return (string) $this->xml[0]->children()->game[0]->$name ?? 'undefined';
    }

    /**
     * get live titles
     *
     * @param string $name
     * @return mixed
     */
    private function transformName(string $name)
    {
        $transforms = [
            'ior_RH' => 'ior_REH',
            'ior_RC' => 'ior_REC',
            'ratio_rouo' => 'ratio_o',
            'ratio_rouu' => 'ratio_u',
            'ior_ROUH' => 'ior_OUH',
            'ior_ROUC' => 'ior_OUC',
            'ior_REOO' => 'ior_EOO',
            'ior_REOE' => 'ior_EOE',
            'ratio_ouho' => 'ratio_rouhu',
            'ratio_ouhu' => 'ratio_rouhu',
            'ior_OUHO' => 'ior_ROUHO',
            'ior_OUHU' => 'ior_ROUHU',
            'ratio_ouco' => 'ratio_rouco',
            'ratio_oucu' => 'ratio_roucu',
            'ior_OUCO' => 'ior_ROUCO',
            'ior_OUCU' => 'ior_ROUCU',
        ];

        return $transforms[$name] ?? $name;
    }
}

<?php

/**
 * Class namespace
 */
namespace App;

/**
 * Used packages
 */

use App\Tools\HgaGetter;
use Illuminate\Database\Eloquent\Model;

/**
 * Class-model for managing matches
 *
 * Class Match
 * @package App
 */
class Match extends Model
{
    /**
     * Model table
     *
     * @var string
     */
    protected $table = 'matches';

    /**
     * Fillable properties of the model
     *
     * @var array
     */
    protected $fillable = [
        'match_id',
        'ratio',
        'ior_RH',
        'ior_RC',
        'ratio_o',
        'ratio_u',
        'ior_OUH',
        'ior_OUC',
        'ior_EOO',
        'ior_EOE',
        'ratio_ouho',
        'ratio_ouhu',
        'ior_OUHO',
        'ior_OUHU',
        'ratio_ouco',
        'ratio_oucu',
        'ior_OUCO',
        'ior_OUCU',
        'is_live',
        'sport_type',
        'league',
        'team_h',
        'team_c',
    ];

    /**
     * exceptions which cannot be set dynamically
     *
     * @var array
     */
    protected $disableDynamicalSet = [
        'match_id',
        'is_live',
        'sport_type',
    ];

    /**
     * properties which should be string
     *
     * @var array
     */
    protected $stringProperties = [
        'league',
        'team_h',
        'team_c',
    ];

    /**
     * set by getter
     *
     * @param HgaGetter $getter
     * @param array $additional
     * @return $this
     */
    public function set(HgaGetter $getter, array $additional = [])
    {
        foreach ($this->getFillable() as $property) {
            if (array_search($property, $this->disableDynamicalSet) !== FALSE)
                continue;

            if (array_search($property, $this->stringProperties) === FALSE) $this->$property = (float) $getter->$property();
            if (array_search($property, $this->stringProperties) !== FALSE) $this->$property = (string) $getter->$property();
        }

        foreach ($additional as $property => $value)
            $this->$property = $value;

        return $this;
    }
}

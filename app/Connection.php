<?php

/**
 * Class namespace
 */
namespace App;

/**
 * Used packages
 */
use Illuminate\Database\Eloquent\Model;

/**
 * Class-model for managing connections
 *
 * Class Connection
 * @package App
 */
class Connection extends Model
{
    /**
     * Model table
     *
     * @var string
     */
    protected $table = 'connections';

    /**
     * Model fillable properties
     *
     * @var array
     */
    protected $fillable = [
        'uid',
    ];

    /**
     * get last active connection
     *
     * @return mixed
     */
    public static function get()
    {
        return self::orderBy('id', 'DESC')->first();
    }
}

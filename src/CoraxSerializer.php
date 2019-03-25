<?php
/**
 * Created by PhpStorm.
 * User: arashrasoulzadeh
 * Date: 2019-03-20
 * Time: 00:23
 */

namespace arashrasoulzadeh\corax;

/**
 * de/serializer class for corax
 * Class CoraxSerializer
 * @package arashrasoulzadeh\corax
 */
class CoraxSerializer
{
    public static function serialize($object): string
    {
        return json_encode($object);
    }

    public static function deserialize($string): object
    {
        return json_decode($string);
    }
}
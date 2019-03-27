<?php
/**
 * Created by PhpStorm.
 * User: arashrasoulzadeh
 * Date: 2019-03-20
 * Time: 00:23
 */

namespace arashrasoulzadeh\corax;

use arashrasoulzadeh\corax\interfaces\SerializerInterface;

/**
 * de/serializer class for corax
 * Class CoraxSerializer
 * @package arashrasoulzadeh\corax
 */
class CoraxSerializer implements SerializerInterface
{

    /**
     * serialize the input
     * @return mixed
     */
    public function serialize($input)
    {
        return json_encode($input);
    }

    /**
     * deserialize the input
     * @return mixed
     */
    public function deserialize($input)
    {
        return json_decode($input);
    }
}
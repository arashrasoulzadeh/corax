<?php
/**
 * Created by PhpStorm.
 * User: arashrasoulzadeh
 * Date: 2019-03-26
 * Time: 03:26
 */

namespace arashrasoulzadeh\corax\interfaces;


interface SerializerInterface
{
    /**
     * serialize the input
     * @return mixed
     */
    public function serialize($input);

    /**
     * deserialize the input
     * @return mixed
     */
    public function deserialize($input);
}
<?php
/**
 * Created by PhpStorm.
 * User: arashrasoulzadeh
 * Date: 2019-03-18
 * Time: 22:27
 */

namespace arashrasoulzadeh\corax\interfaces;

interface TransportDeviceInterface
{
    public function listen();

    public function say();


}
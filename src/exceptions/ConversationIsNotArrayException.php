<?php
/**
 * Created by PhpStorm.
 * User: arashrasoulzadeh
 * Date: 2019-03-26
 * Time: 01:51
 */

namespace arashrasoulzadeh\corax\exceptions;

use Exception;

class ConversationIsNotArrayException extends Exception
{
    public function errorMessage()
    {
        return "not array";
    }
}
<?php

namespace arashrasoulzadeh\corax\Controllers;


use arashrasoulzadeh\corax\services\Corax;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Redis;

class CoraxController extends Controller
{
    //


    public function listen()
    {
        return Corax::builder()->getTransportDevice()->listen();
    }

    public function hello()
    {

        Corax::builder()->sendMessage(
            1,
            2,
            Corax::builder()->makePayload(
                "hello there"
            ));
    }
}

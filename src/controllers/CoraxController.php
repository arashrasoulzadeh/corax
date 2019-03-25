<?php

namespace arashrasoulzadeh\corax\Controllers;


use arashrasoulzadeh\corax\services\Corax;
use Illuminate\Routing\Controller;

/**
 * sample controller
 * Class CoraxController
 * @package arashrasoulzadeh\corax\Controllers
 */
class CoraxController extends Controller
{
    //


    public function listen()
    {
        return Corax::builder()->getTransportDevice()->listen();
    }

    public function hello()
    {
//
//            Corax::builder()->sendMessage(
//                2,
//                1,
//                Corax::builder()->makePayload(
//                    "how are you ?"
//                ));


        $conv = Corax::builder()->getConversation(1, 2);
        return $conv;
    }
}

<?php

namespace arashrasoulzadeh\corax\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;

class ReceiveMessageListener implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object $event
     * @return void
     */
    public function handle($event)
    {

    }
}

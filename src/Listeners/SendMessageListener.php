<?php

namespace arashrasoulzadeh\corax\Listeners;

use arashrasoulzadeh\corax\services\Corax;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendMessageListener implements ShouldQueue
{
    public $storage;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        $this->storage = Corax::builder()->getStorageDevice();
    }

    /**
     * Handle the event.
     *
     * @param  object $event
     * @return void
     */
    public function handle($event)
    {
        $event_deserialized = Corax::builder()->getSerializer()->deserialize($event);
        (new $this->storage(1, 2,Corax::builder()->getCacheDevice()))->set($event);
    }
}

<?php

namespace arashrasoulzadeh\corax;

use arashrasoulzadeh\corax\Events\SendMessageEvent;
use arashrasoulzadeh\corax\Listeners\ReceiveMessageListener;
use arashrasoulzadeh\corax\Listeners\SendMessageListener;
use arashrasoulzadeh\corax\services\Corax;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class CoraxServiceProvider extends ServiceProvider
{


    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //load Corax singleton
        $this->app->singleton(Corax::class, function ($app) {
            return new Corax(config('app.corax.type', Corax::$CORAX_TYPE_HTTP));
        });


        //load routes
        $this->loadRoutesFrom(__DIR__ . '/routes.php');


        //register events
        Event::listen('corax.sendmessage', function ($payload) {
            (config("app.corax.listener.send", new SendMessageListener()))->handle($payload);
        });
        Event::listen('corax.receivemessage', function ($payload) {
            (config("app.corax.listener.receive", new ReceiveMessageListener()))->handle($payload);
        });

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

    }
}

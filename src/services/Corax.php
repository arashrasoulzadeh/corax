<?php
/**
 * Created by PhpStorm.
 * User: arashrasoulzadeh
 * Date: 2019-03-18
 * Time: 20:05
 */

namespace arashrasoulzadeh\corax\services;

use arashrasoulzadeh\corax\devices\HttpTransferDevice;
use Illuminate\Support\Facades\App;
use Psr\Log\LoggerInterface;

class Corax
{
    public $type = 0;
    private $logger;
    private $transportDevice = null;

    public static $CORAX_TYPE_HTTP = 0;

    public static $CORAX_MESSAGE_TYPE_TEX = 0;

    public function __construct($type, LoggerInterface $logger = null)
    {
        $this->type = $type;
        $this->logger = $logger;
        $this->transportDevice = $this->getTransportDevice();
    }


    public static function builder(): Corax
    {
        return App::make(Corax::class);

    }

    public function getTransportDevice()
    {
        return $this->transportDevice == null ? new HttpTransferDevice() : $this->transportDevice;
    }


    public function sendMessage($from, $to, $payload)
    {
        event('corax.sendmessage', ["from" => $from, "to" => $to, "payload" => $payload]);
        $this->log("message sent");
    }

    public function log($message, $section = "global")
    {
        if ($this->logger) {
            $this->logger->info('Doing work');
        }
        dump(["section" => $section, "message" => $message]);
    }


    public function makePayload($message, $type = 0, $extra = null)
    {
        return [
            "message" => $message,
            "type" => $type
        ];
    }

}
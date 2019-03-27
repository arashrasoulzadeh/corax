<?php
/**
 * Created by PhpStorm.
 * User: arashrasoulzadeh
 * Date: 2019-03-18
 * Time: 20:05
 */

namespace arashrasoulzadeh\corax\services;

use arashrasoulzadeh\corax\CoraxSerializer;
use arashrasoulzadeh\corax\devices\HttpTransferDevice;
use arashrasoulzadeh\corax\interfaces\CacheInterface;
use arashrasoulzadeh\corax\interfaces\SerializerInterface;
use arashrasoulzadeh\corax\interfaces\StorageInterface;
use Illuminate\Support\Facades\App;
use Psr\Log\LoggerInterface;

class Corax
{
    public $type = 0;
    private $logger;
    private $cache;
    private $serializer;
    private $storage = StorageInterface::class;
    private $transportDevice = null;

    public static $CORAX_TYPE_HTTP = 0;

    public static $CORAX_MESSAGE_TYPE_TEX = 0;

    /**
     * Corax constructor.
     * @param $type
     * @param $storage
     * @param $cache
     * @param LoggerInterface|null $logger
     */
    public function __construct($type, $storage, $cache, $serializer, LoggerInterface $logger = null)
    {
        $this->type = $type;
        $this->serializer = new $serializer;
        $this->logger = $logger;
        $this->cache = new $cache;
        $this->transportDevice = new HttpTransferDevice();
        $this->storage = $storage;
    }


    public function getSerializer(): SerializerInterface
    {
        return $this->serializer;
    }

    /**
     * builder class
     * @return Corax
     */
    public static function builder(): Corax
    {
        return App::make(Corax::class);

    }

    /**
     * @return HttpTransferDevice|null
     */
    public function getTransportDevice()
    {
        return $this->transportDevice;
    }

    /**
     * @return StorageInterface
     */
    public function getStorageDevice(): StorageInterface
    {
        if (is_string($this->storage))
            $this->storage = new $this->storage(1, 2, $this->cache);
        return $this->storage;
    }


    public function sendMessage($from, $to, $payload)
    {
//        $this->getCacheDevice()->setChanges($payload->id, $payload);
        event('corax.sendmessage',

            Corax::builder()->getSerializer()->serialize(["from" => $from, "to" => $to, "payload" => $payload])
        );
        $this->log("message sent");
    }

    /**
     * @return CacheInterface
     */
    public function getCacheDevice(): CacheInterface
    {
        return $this->cache;
    }

    /**
     * @param $from
     * @param $to
     * @return mixed
     */
    public function getConversation($from, $to)
    {
        $this->storage = Corax::builder()->getStorageDevice();
        $cache = $this->getCacheDevice();
        return (new $this->storage($from, $to, $cache))->conversation();
    }


    /**
     * @param $message
     * @param string $section
     */
    public function log($message, $section = "global")
    {
        if ($this->logger) {
            $this->logger->info('Doing work');
        }
    }


    /**
     * make conversation payload
     * @param $message
     * @param int $type
     * @param null $extra
     * @return array
     */
    public function makePayload($message, $type = 0, $extra = null)
    {
        return [
            "message" => $message,
            "type" => $type
        ];
    }

}
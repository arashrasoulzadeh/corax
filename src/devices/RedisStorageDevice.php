<?php
/**
 * Created by PhpStorm.
 * User: arashrasoulzadeh
 * Date: 2019-03-19
 * Time: 02:50
 */

namespace arashrasoulzadeh\corax\devices;


use arashrasoulzadeh\corax\CoraxSerializer;
use arashrasoulzadeh\corax\exceptions\ConversationIsNotArrayException;
use arashrasoulzadeh\corax\interfaces\CacheInterface;
use arashrasoulzadeh\corax\interfaces\StorageInterface;
use Illuminate\Support\Facades\Redis;

class RedisStorageDevice implements StorageInterface
{
    public $key;
    public $cache;

    public function __construct($from, $to, $cache)
    {
        $this->cache = $cache;
        $this->key = "$from-$to";
    }

    public function getCache(): CacheInterface
    {
        return $this->cache;
    }

    public function getCounter()
    {
        return Redis::command("incr", [$this->key . "counter"]);
    }

    public function injectId($message): string
    {
        $obj = CoraxSerializer::deserialize($message);
        $obj->id = $this->getCounter();
        return CoraxSerializer::serialize($obj);
    }

    public function set($message)
    {
        return Redis::rpush($this->key, $this->injectId($message));
    }

    public function get($id)
    {
        $data = [];
        $data = Redis::lrange($this->key, $id, $id + 1);
        return $this->deserializeConversation($data);
    }

    public function delete($id)
    {
        // TODO: Implement delete() method.
    }

    public function deserializeConversation($data)
    {
        if (!is_array($data))
            throw new ConversationIsNotArrayException();
        return array_map(function ($item) {
            return CoraxSerializer::deserialize($item);
        }, $data);
    }

    public function conversation()
    {
        $data = [];
        if ($this->getCache()->isChanged($this->key)) {
            $data = Redis::lrange($this->key, 0, -1);
        } else {
            $data = $this->getCache()->getCached($this->key);
        }

        return $this->deserializeConversation($data);
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: arashrasoulzadeh
 * Date: 2019-03-19
 * Time: 02:50
 */

namespace arashrasoulzadeh\corax\devices;


use arashrasoulzadeh\corax\exceptions\ConversationIsNotArrayException;
use arashrasoulzadeh\corax\interfaces\CacheInterface;
use arashrasoulzadeh\corax\interfaces\StorageInterface;
use arashrasoulzadeh\corax\services\Corax;
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
        $obj = Corax::builder()->getSerializer()->deserialize($message);
        $obj->id = $this->getCounter();
        return Corax::builder()->getSerializer()->serialize($obj);
    }

    public function set($message)
    {
        $this->getCache()->delete($this->key);
        $message = $this->injectId($message);
        $id = Corax::builder()->getSerializer()->deserialize($message)->id;
        $result = Redis::rpush($this->key, $message);
        $conversation = Corax::builder()->getSerializer()->serialize($this->conversation());
        Corax::builder()->getCacheDevice()->setChanges($this->key, $conversation);
        return $result;
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
        try {
            if (is_string($data))
                throw new ConversationIsNotArrayException();
        } catch (ConversationIsNotArrayException $e) {
            throw new ConversationIsNotArrayException("saved conversation is not an array!");
        }
        return array_map(function ($item) {
            if (is_object($item))
                return $item;
            if (is_string($item))
                return Corax::builder()->getSerializer()->deserialize(
                    $item
                );
            else
                return [];
        }, $data);
    }

    public function conversation()
    {
        $data = [];
        if ($this->getCache()->isChanged($this->key)) {
            $data = Redis::lrange($this->key, 0, -1);
            $this->getCache()->setChanges(
                $this->key,
                Corax::builder()->getSerializer()->serialize($data)
            );
        } else {
            $data = Corax::builder()->getSerializer()->deserialize($this->getCache()->getCached($this->key));
        }

        return $this->deserializeConversation($data);
    }
}
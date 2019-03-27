<?php
/**
 * Created by PhpStorm.
 * User: arashrasoulzadeh
 * Date: 2019-03-25
 * Time: 19:31
 */

namespace arashrasoulzadeh\corax\devices;


use arashrasoulzadeh\corax\interfaces\CacheInterface;
use arashrasoulzadeh\corax\interfaces\StorageInterface;
use Illuminate\Support\Facades\Redis;

class RedisCacheDevice implements CacheInterface
{

    /**
     * check weather real value is different from cached data or not
     * @param $key
     * @return bool
     */
    public function isChanged($key): bool
    {
        $key = "CHANGED?" . $this->getKey($key);
        $key = Redis::get($key);
        if (empty($key)) {
            return true;
        }
        return false;
    }

    /**
     * returns the key used for identifying
     * @param $args
     * @return mixed
     */
    public function getKey($args)
    {
        return "CACHE" . $args;
    }

    /**
     * returns the cached value
     * @param $key
     * @return StorageInterface
     */
    public function getCached($key)
    {
        return Redis::get($this->getKey($key));
    }

    /**
     * set cache value by key
     * @param $key
     * @param $newValue
     */
    public function setChanges($key, $newValue)
    {
        Redis::set("CHANGED?" . $this->getKey($key),now());
        return Redis::set($this->getKey($key), $newValue);
    }


    /**
     * delete the key from cache
     * @param $key
     * @return mixed
     */
    public function delete($key)
    {

        Redis::set("CHANGED?" . $this->getKey($key), null);
    }
}
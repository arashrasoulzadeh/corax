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
use arashrasoulzadeh\corax\services\Corax;
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
        return false;
    }

    /**
     * returns the cached value
     * @param $key
     * @return StorageInterface
     */
    public function getCached($key)
    {
        $key = "CACHE" . $key;
        return Redis::get($key);
    }

    /**
     * set cache value by key
     * @param $key
     * @param $newValue
     */
    public function setChanges($key, $newValue)
    {

    }
}
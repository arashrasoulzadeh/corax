<?php
/**
 * Created by PhpStorm.
 * User: arashrasoulzadeh
 * Date: 2019-03-24
 * Time: 23:38
 */

namespace arashrasoulzadeh\corax\interfaces;

/**
 * Interface CacheInterface
 * @package arashrasoulzadeh\corax\interfaces
 */
interface CacheInterface
{
    /**
     * check weather real value is different from cached data or not
     * @param $key
     * @return bool
     */
    public function isChanged($key): bool;

    /**
     * returns the cached value
     * @param $key
     * @return StorageInterface
     */
    public function getCached($key);

    /**
     * set cache value by key
     * @param $key
     * @param $newValue
     */
    public function setChanges($key, $newValue);
}
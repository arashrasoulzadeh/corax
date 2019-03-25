<?php
/**
 * Created by PhpStorm.
 * User: arashrasoulzadeh
 * Date: 2019-03-19
 * Time: 02:38
 */

namespace arashrasoulzadeh\corax\interfaces;


interface StorageInterface
{
    /**
     * StorageInterface constructor.
     * @param $from
     * @param $to
     * @param $cache
     */
    public function __construct($from, $to,$cache);

    /**
     * set the value in device
     * @param $message
     * @return mixed
     */
    public function set($message);

    /**
     * get the value from device
     * @param $id
     * @return mixed
     */
    public function get($id);

    /**
     * delete a value from device
     * @param $id
     * @return mixed
     */
    public function delete($id);

    /**
     * get a conversation list
     * @return mixed
     */
    public function conversation();

}
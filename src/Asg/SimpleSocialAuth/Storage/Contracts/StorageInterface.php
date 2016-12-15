<?php
/**
 * Created by PhpStorm.
 * User: abed
 * Date: 12/13/16
 * Time: 11:59 AM
 */

namespace Asg\SimpleSocialAuth\Storage\Contracts;


interface StorageInterface {

    /**
     * @param string $name;
     * @param mixed $value;
     * @return StorageInterface
     * */
    public function set($name,$value);

    /**
     * @param string $name;
     * @return mixed|null;
     * */
    public function get($name);

    /**
     * @param string $name;
     * */
    public function destroy($name);


    public function clear();
    /**
     * @param string $name;
     * @return bool;
     * */
    public function exists($name);
}
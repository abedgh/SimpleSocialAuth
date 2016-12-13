<?php
/**
 * Created by PhpStorm.
 * User: abed
 * Date: 12/13/16
 * Time: 11:59 AM
 */

namespace Asg\Storage\Contracts;


interface StorageInterface {

    /**
     * @param string $name;
     * @param array $value;
     * @return StorageInterface
     * */
    public function set($name,array $value);

    /**
     * @param string $name;
     * @return array|null;
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
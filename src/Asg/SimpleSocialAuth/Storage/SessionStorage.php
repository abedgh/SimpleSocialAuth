<?php
/**
 * Created by PhpStorm.
 * User: abed
 * Date: 12/13/16
 * Time: 12:02 PM
 */

namespace Asg\SimpleSocialAuth\Storage;

use Asg\SimpleSocialAuth\Storage\Contracts\StorageInterface;

class SessionStorage implements StorageInterface{

    protected $sessionId = 'SessionStorageId';

    function __construct($sessionId = null){
        if ($sessionId != null) {
           $this->sessionId = $sessionId;
        }
        $_SESSION[$this->sessionId] = [];
        $this->startSession();
    }

    protected function startSession()
    {
        if (session_status() != PHP_SESSION_ACTIVE) {
            session_start();
        }
    }

    /**
     * @param string $name ;
     * @param mixed $value ;
     * @return StorageInterface
     * */
    public function set($name, $value)
    {
        $_SESSION[$this->sessionId][$name] = $value;
    }

    /**
     * @param string $name ;
     * @return mixed|null;
     * */
    public function get($name)
    {
        if ($this->exists($name)){
            return $_SESSION[$this->sessionId][$name];
        }
        return null;
    }

    /**
     * @param string $name ;
     * */
    public function destroy($name)
    {
        if ($this->exists($name) ) {
            unset($_SESSION[$this->sessionId][$name]);
        }
    }

    /**
     * @param string $name ;
     * @return bool;
     * */
    public function exists($name)
    {
        return isset($_SESSION[$this->sessionId][$name]);
    }

    /**
     * @return void;
     * */
    public function clear(){
        unset($_SESSION[$this->sessionId]);
    }
}
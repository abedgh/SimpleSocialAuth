<?php
/**
 * Created by PhpStorm.
 * User: abed
 * Date: 12/13/16
 * Time: 12:02 PM
 */

namespace Asg\Storage;


use Asg\Storage\Contracts\StorageInterface;

class SessionStorage implements StorageInterface{

    protected $prefixSessionId = 'Asg::';
    protected $sessionId = 'SessionStorageId';

    function __construct($sessionId = null){
        if ($sessionId != null) {
            $this->sessionId = $sessionId;
        }
        $this->startSession();
    }

    protected function startSession()
    {
        if (session_status() != PHP_SESSION_ACTIVE) {
            ini_set('session.name',$this->prefixSessionId.substr(md5($this->sessionId),0,5));
            ini_set('session.use_strict_mode', 1);
            session_start();
        }
    }

    /**
     * @param string $name ;
     * @param array $value ;
     * @return StorageInterface
     * */
    public function set($name, array $value)
    {

    }

    /**
     * @param string $name ;
     * @return array;
     * */
    public function get($name)
    {
        // TODO: Implement get() method.
    }

    /**
     * @param string $name ;
     * */
    public function destroy($name)
    {
        // TODO: Implement destroy() method.
    }

    /**
     * @param string $name ;
     * @return bool;
     * */
    public function exists($name)
    {
        // TODO: Implement exists() method.
    }
}
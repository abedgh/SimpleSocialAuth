<?php
/**
 * Created by PhpStorm.
 * User: abed
 * Date: 12/14/16
 * Time: 8:23 PM
 */

namespace Asg\SimpleSocialAuth\Providers\GooglePlus;


use Asg\SimpleSocialAuth\Providers\BaseSocialResponse;

class GooglePlusSocialResponse extends BaseSocialResponse{

    protected $user;

    function __construct($user){
        $this->user = $user;
    }
    /**
     * @return mixed|null;
     * */
    public function getId()
    {
        // TODO: Implement getId() method.
    }

    /**
     * @return string|null
     * */
    public function getEmail()
    {
        // TODO: Implement getEmail() method.
    }

    /**
     * @return string
     * */
    public function getName()
    {
        // TODO: Implement getName() method.
    }

    /**
     * @return string
     * */
    public function getFirstName()
    {
        // TODO: Implement getFirstName() method.
    }

    /**
     * @return string
     * */
    public function getLastName()
    {
        // TODO: Implement getLastName() method.
    }

    /**
     * @param string $name ;
     * @return mixed|null;
     * */
    public function getField($name)
    {
        // TODO: Implement getField() method.
    }

    /**
     * @return bool;
     * */
    public function isVerified()
    {
        // TODO: Implement isVerified() method.
    }

    /**
     * @return mixed;
     * */
    public function payload()
    {
        // TODO: Implement payload() method.
    }
}
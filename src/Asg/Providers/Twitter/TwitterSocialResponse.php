<?php
/**
 * Created by PhpStorm.
 * User: abed
 * Date: 12/13/16
 * Time: 7:56 PM
 */

namespace Asg\Providers\Twitter;


use Asg\Providers\BaseSocialResponse;

class TwitterSocialResponse extends BaseSocialResponse{

    protected $twitterUser;


    function __construct($twitterUser){
        $this->twitterUser = $twitterUser;
    }

    /**
     * @return mixed|null;
     * */
    public function getId()
    {
        return $this->twitterUser->id;
    }

    /**
     * @return string|null
     * */
    public function getEmail()
    {
        return isset($this->twitterUser->email)?$this->twitterUser->email:null;
    }

    /**
     * @return string
     * */
    public function getName()
    {
        return $this->twitterUser->name;
    }

    /**
     * @return string
     * */
    public function getFirstName()
    {
        $names = explode(' ',$this->getName());
        return $names[0];
    }

    /**
     * @return string
     * */
    public function getLastName()
    {
        $names = explode(' ',$this->getName());
        return $names[count($names)-1];
    }

    /**
     * @param string $name ;
     * @return mixed|null;
     * */
    public function getField($name)
    {
        return isset($this->twitterUser->{$name})?$this->twitterUser->{$name}:null;
    }

    /**
     * @return bool;
     * */
    public function isVerified()
    {
        $verified = isset($this->twitterUser->verified)?$this->twitterUser->verified:false;
        return is_bool($verified)?$verified:false;
    }

    /**
     * @return mixed;
     * */
    public function payload()
    {
        return $this->twitterUser;
    }
}
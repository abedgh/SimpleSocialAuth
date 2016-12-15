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

    /**
     * @var \Google_Service_Plus_Person;
     * */
    protected $user;

    function __construct(\Google_Service_Plus_Person $user){
        $this->user = $user;
    }
    /**
     * @return mixed|null;
     * */
    public function getId()
    {
        return $this->user->getId();
    }

    /**
     * @return string|null
     * */
    public function getEmail()
    {
        $email = $this->user->getEmails();
        if ($email && is_array($email) && count($email) > 0){
            return $email[0]->value;
        }
        return null;
    }

    /**
     * @return string
     * */
    public function getName()
    {
        return $this->user->getDisplayName();
    }

    /**
     * @return string
     * */
    public function getFirstName()
    {
        $name = $this->user->getName();
        if ($name && $name instanceof \Google_Service_Plus_PersonName){
            return $name->getGivenName();
        }else{
            return $this->extractFirstNameFromName();
        }
    }

    /**
     * @return string
     * */
    public function getLastName()
    {
        $name = $this->user->getName();
        if ($name && $name instanceof \Google_Service_Plus_PersonName){
            return $name->getFamilyName();
        }else{
            return $this->extractLastNameFromName();
        }
    }

    /**
     * @param string $name ;
     * @return mixed|null;
     * */
    public function getField($name)
    {
        return isset($this->user->{$name})?$this->user->{$name}:null;
    }

    /**
     * @return bool;
     * */
    public function isVerified()
    {
        return $this->user->getVerified();
    }

    /**
     * @return \Google_Service_Plus_Person;
     * */
    public function payload()
    {
        return $this->user;
    }
}
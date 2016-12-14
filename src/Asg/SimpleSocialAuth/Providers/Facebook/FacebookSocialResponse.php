<?php
/**
 * Created by PhpStorm.
 * User: abed
 * Date: 12/12/16
 * Time: 7:04 PM
 */

namespace Asg\SimpleSocialAuth\Providers\Facebook;

use \Facebook\GraphNodes\GraphUser;
use Asg\SimpleSocialAuth\Providers\BaseSocialResponse;

class FacebookSocialResponse extends BaseSocialResponse{

    /**
     * @var GraphUser;
     * */
    protected $graphUser;

    function __construct(GraphUser $graphUser){
        $this->graphUser = $graphUser;
    }
    /**
     * @return mixed|null;
     * */
    public function getId()
    {
        return $this->graphUser->getId();
    }

    /**
     * @return string|null
     * */
    public function getEmail()
    {
        return $this->graphUser->getEmail();
    }

    /**
     * @return string
     * */
    public function getName()
    {
        return $this->graphUser->getName();
    }

    /**
     * @return string
     * */
    public function getFirstName()
    {
        return $this->graphUser->getFirstName();
    }

    /**
     * @return string
     * */
    public function getLastName()
    {
        return $this->graphUser->getLastName();
    }

    /**
     * @return bool;
     * */
    public function isVerified()
    {
        return $this->graphUser->getField('verified',false);
    }

    /**
     * @return mixed;
     * */
    public function payload()
    {
        return $this->graphUser;
    }

    /**
     * @param string $name ;
     * @return mixed;
     * */
    public function getField($name)
    {
        return $this->graphUser->getField($name,null);
    }
}
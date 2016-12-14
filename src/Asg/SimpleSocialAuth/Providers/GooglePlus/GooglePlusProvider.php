<?php
/**
 * Created by PhpStorm.
 * User: abed
 * Date: 12/14/16
 * Time: 8:21 PM
 */

namespace Asg\SimpleSocialAuth\Providers\GooglePlus;


use Asg\SimpleSocialAuth\Providers\BaseProvider;
use Asg\SimpleSocialAuth\Providers\Contracts\SocialResponseInterface;

class GooglePlus extends BaseProvider{

    protected $providerId = 3;
    protected $providerName = 'GooglePlus';

    function __construct($config){
        parent::__construct($config);

    }
    /**
     * @param string $callbackUrl ;
     * @return void;
     * */
    public function login($callbackUrl = '')
    {

    }

    /**
     * @return SocialResponseInterface;
     * */
    public function getSocialResponse()
    {

        return new GooglePlusSocialResponse(null);
    }
}
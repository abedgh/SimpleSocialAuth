<?php
/**
 * Created by PhpStorm.
 * User: abed
 * Date: 12/13/16
 * Time: 10:56 AM
 */

namespace MyApp;


use Asg\SimpleSocialAuth\Providers\BaseProvider;
use Asg\SimpleSocialAuth\Providers\Contracts\SocialResponseInterface;

class FakeFacebookProvider extends BaseProvider {

    protected $providerName = 'Facebook';

    function __construct($config){
        parent::__construct($config);
    }
    /**
     * @param string $callbackUrl ;
     * @return void;
     * */
    public function login($callbackUrl = '')
    {
        // TODO: Implement login() method.
    }

    /**
     * @return SocialResponseInterface;
     * */
    public function getSocialResponse()
    {

    }
}
<?php
/**
 * Created by PhpStorm.
 * User: abed
 * Date: 12/12/16
 * Time: 6:17 PM
 */

namespace Asg\SimpleSocialAuth\Providers\Contracts;

interface SimpleSocialAuthInterface {

    /**
     * @param string $callbackUrl;
     * @return void;
     * */
    public function login($callbackUrl = '');

    /**
     * @return int;
     * */
    public function getProviderId();

    /**
     * @return string;
     * */
    public function getProviderName();

    /**
     * @return SocialResponseInterface;
     * */
    public function getSocialResponse();
    /**
     * @return $string;
     * */
    public function getCallbackUrl();

    /**
     * @param string $callbackUrl;
     * @return SimpleSocialAuthInterface;
     * */
    public function setCallbackUrl($callbackUrl);

    /**
     * @param array $options;
     * @return SimpleSocialAuthInterface;
     * */
    public function setOptions(array $options);

}
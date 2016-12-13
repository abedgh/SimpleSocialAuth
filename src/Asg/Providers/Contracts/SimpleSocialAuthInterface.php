<?php
/**
 * Created by PhpStorm.
 * User: abed
 * Date: 12/12/16
 * Time: 6:17 PM
 */

namespace Asg\Providers\Contracts;

interface SimpleSocialAuthInterface {

    /**
     * @param string $callbackUrl;
     * @param string[] $options;
     * @return void;
     * */
    public function login($callbackUrl = '', $options = []);

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

}
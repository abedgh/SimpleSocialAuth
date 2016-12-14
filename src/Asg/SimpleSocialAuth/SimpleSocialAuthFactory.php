<?php
/**
 * Created by PhpStorm.
 * User: abed
 * Date: 12/12/16
 * Time: 6:14 PM
 */

namespace Asg\SimpleSocialAuth;

use Asg\SimpleSocialAuth\Exceptions\SocialAuthInvalidInterface;
use Asg\SimpleSocialAuth\Exceptions\SocialAuthProviderNotFound;
use Asg\SimpleSocialAuth\Providers\Contracts\SimpleSocialAuthInterface;

class SimpleSocialAuthFactory {

    protected static $classMaps = [
        'Facebook' => \Asg\SimpleSocialAuth\Providers\Facebook\FacebookProvider::class,
        'Twitter' => \Asg\SimpleSocialAuth\Providers\Twitter\TwitterProvider::class,
    ];
    /**
     * @access Public static;
     * @param string $provider ;
     * @param string[] $config ;
     * @return Providers\Contracts\SimpleSocialAuthInterface ;
     * @throws SocialAuthProviderNotFound
     */
    public static function make($provider,$config = []){
        $provider = ucfirst(strtolower($provider));
        if ( array_key_exists($provider,static::$classMaps) ){
            $class = static::$classMaps[$provider];
        }else {
            $class = 'Asg\\Providers\\' . $provider . '\\' . $provider . 'Provider';
        }
        if (class_exists($class) ){
            return new $class($config);
        }
        throw new SocialAuthProviderNotFound('Cant found provider in the following path: '.$class);
    }

    /**
     * @description : Used to register new classes and mapped them to allow to extend custom classes.
     * @access Public static;
     * @param string $provider ;
     * @param string $className ;
     * @throws SocialAuthInvalidInterface
     */
    public static function register($provider,$className){
        $provider = ucfirst(strtolower($provider));
        $class = new \ReflectionClass($className);
        if ( $class->implementsInterface(SimpleSocialAuthInterface::class) ) {
            static::$classMaps[$provider] = $className;
        }else{
            throw new SocialAuthInvalidInterface('Class must implement SimpleSocialAuthInterface');
        }
    }
}
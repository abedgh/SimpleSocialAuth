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
        'GooglePlus' => \Asg\SimpleSocialAuth\Providers\GooglePlus\GooglePlusProvider::class,
    ];
    /**
     * @access Public static;
     * @param string $provider ;
     * @param string[] $config ;
     * @return Providers\Contracts\SimpleSocialAuthInterface ;
     * @throws SocialAuthProviderNotFound
     */
    public static function make($provider,$config = []){

        if ( array_key_exists($provider,static::$classMaps) ){
            $class = static::$classMaps[$provider];
        }else {
            $class = 'Asg\\Providers\\' . $provider . '\\' . $provider . 'Provider';
        }
        return static::invoke($class,$config);
    }

    /**
     * @description : Used to register new classes and mapped them to allow to extend custom classes.
     * @access Public static;
     * @param string $provider ;
     * @param string $callableClass ;
     * @throws SocialAuthInvalidInterface
     */
    public static function register($provider,$callableClass){
        if ( is_callable($callableClass) or
            static::isSimpleSocialAuthInterface($callableClass) ) {
            static::$classMaps[$provider] = $callableClass;
        }else{
            throw new SocialAuthInvalidInterface('Class must be implemented from SimpleSocialAuthInterface');
        }
    }

    /**
     * @param string|object $class ;
     * @return bool
     */
    protected static function isSimpleSocialAuthInterface($class){
        return (new \ReflectionClass($class))->implementsInterface(SimpleSocialAuthInterface::class);
    }

    /**
     * @param string|object $class ;
     * @param $config
     * @return SimpleSocialAuthInterface ;
     * @throws SocialAuthInvalidInterface
     * @throws SocialAuthProviderNotFound
     * @pram string[] $config;
     */
    protected static function invoke($class,$config){

        if( is_callable($class) ){
            $class = $class($config);
            if (static::isSimpleSocialAuthInterface($class)) {
                return $class;
            }
        }elseif ( class_exists($class) && static::isSimpleSocialAuthInterface($class) ){
            return new $class($config);
        }else{
            if ( is_callable($class) ){
                throw new SocialAuthInvalidInterface('Class must be implemented from SimpleSocialAuthInterface');
            }else {
                throw new SocialAuthProviderNotFound('Cant found provider in the following path: ' . $class);
            }
        }
    }

}
<?php
/**
 * Created by PhpStorm.
 * User: abed
 * Date: 12/14/16
 * Time: 12:17 PM
 */

require_once __DIR__.'/FakeFacebookProvider.php';
use \Asg\SimpleSocialAuth\SimpleSocialAuthFactory;

class FacebookTest extends PHPUnit_Framework_TestCase{


    public static function setUpBeforeClass(){
        SimpleSocialAuthFactory::register('FakeFacebook',\MyApp\FakeFacebookProvider::class);
    }

    public function testCheckIsFacebookInstance(){
        $auth = SimpleSocialAuthFactory::make('FakeFacebook',[]);
        $this->assertEquals($auth->getProviderName() , 'Facebook');
    }
}
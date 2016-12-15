<?php
/**
 * Created by PhpStorm.
 * User: abed
 * Date: 12/13/16
 * Time: 11:41 AM
 */

namespace Asg\SimpleSocialAuth\Providers;


use Asg\SimpleSocialAuth\Providers\Contracts\SocialResponseInterface;

abstract class BaseSocialResponse implements SocialResponseInterface{

    /**
     * @return string|null
     * */
    protected function extractFirstNameFromName(){
        $names = explode(' ',$this->getName());
        return is_array($names)?$names[0]:null;
    }
    /**
     * @return string|null
     * */
    protected function extractLastNameFromName(){
        $names = explode(' ',$this->getName());
        return is_array($names)?$names[count($names)-1]:null;
    }

}
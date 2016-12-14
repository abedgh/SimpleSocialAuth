<?php
/**
 * Created by PhpStorm.
 * User: abed
 * Date: 12/12/16
 * Time: 6:26 PM
 */

namespace Asg\SimpleSocialAuth\Providers;

use Asg\SimpleSocialAuth\Exceptions\SocialAuthInvalidParams;
use Asg\SimpleSocialAuth\Providers\Contracts\SimpleSocialAuthInterface;

abstract class BaseProvider implements SimpleSocialAuthInterface {

    protected $providerId = null;
    protected $providerName = null;
    protected $callbackUrl = null;
    protected $config = [];
    protected $options = [];

    function __construct($config){
        $this->config = $config;
        $this->callbackUrl = isset($this->config['callback_url'])?$this->config['callback_url']:null;
        $this->options =  isset($this->config['options'])?$this->config['options']:[];
    }
    /**
     * @return int;
     * */
    public function getProviderId()
    {
        return $this->providerId;
    }

    /**
     * @return string;
     * */
    public function getProviderName()
    {
        return $this->providerName;
    }
    /**
     * @return $string;
     * */
    public function getCallbackUrl()
    {
        return $this->callbackUrl;
    }

    /**
     * @param string $callbackUrl ;
     * @return SimpleSocialAuthInterface ;
     * @throws SocialAuthInvalidParams
     */
    public function setCallbackUrl($callbackUrl)
    {
        if ($callbackUrl != ''  && is_string($callbackUrl) ) {
            $this->callbackUrl = $callbackUrl;
        }else{
            throw new SocialAuthInvalidParams('Callback url cant be empty or object');
        }
        return $this;
    }

    /**
     * @param array $options ;
     * @return SimpleSocialAuthInterface ;
     * @throws SocialAuthInvalidParams
     */
    public function setOptions(array $options)
    {
        if (is_array($options)) {
            $this->options = $options;
        }else{
            throw new SocialAuthInvalidParams('Options must be an array');
        }
    }

    /**
     * @access : protected
     * @return string|null
     * */
    protected function getConfigKeyId(){
        return isset($this->config['keys']['id'])?$this->config['keys']['id']:null;
    }
    /**
     * @access : protected
     * @return string|null
     * */
    protected function getConfigKeySecret(){
        return isset($this->config['keys']['secret'])?$this->config['keys']['secret']:null;
    }
    /**
     * @param string $url;
     * @param bool $exist;
     * */
    protected function redirect($url,$exist = true){
        ob_clean();
        if (headers_sent()){
            echo "<html><script>window.location='{$url}';</script></html>";
        }else{
            header('Location:'.$url);
        }
        if ($exist){
            exit;
        }
    }
}
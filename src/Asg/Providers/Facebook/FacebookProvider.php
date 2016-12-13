<?php
/**
 * Created by PhpStorm.
 * User: abed
 * Date: 12/12/16
 * Time: 6:25 PM
 */

namespace Asg\Providers\Facebook;

use Asg\Exceptions\SocialAuthException;
use Asg\Exceptions\SocialAuthResponseException;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;
use Facebook\Facebook;
use Asg\Providers\BaseProvider;
use Asg\Providers\Contracts\SimpleSocialAuthInterface;
use Asg\Providers\Contracts\SocialResponseInterface;
use Asg\Exceptions\SocialAuthInvalidParams;

class FacebookProvider extends BaseProvider{


    protected $providerId = 1;
    protected $providerName = 'FACEBOOK';

    /**
     * @var \Facebook\Facebook
     * */
    protected $fb = null;

    function __construct($config){
        $this->config = $config;
        $id = $this->getConfigKeyId();
        $secret = $this->getConfigKeySecret();

        $this->callbackUrl = isset($this->config['callback_url'])?$this->config['callback_url']:null;
        $this->setOptions(isset($this->config['options'])?$this->config['options']:[]);

        if ($id != null && $secret != null) {

            $this->fb = new Facebook([
                'app_id' => $id,
                'app_secret' => $secret,
                'default_graph_version' => 'v2.5',
            ]);
        }else{
            throw new SocialAuthInvalidParams('Invalid facebook config');
        }
    }

    /**
     * @param string $callbackUrl ;
     * @throws SocialAuthInvalidParams
     */
    public function login($callbackUrl = '')
    {
        $callbackUrl = !empty($callbackUrl)?$callbackUrl:$this->getCallbackUrl();
        if ($callbackUrl == '' || $callbackUrl == null){
            throw new SocialAuthInvalidParams('Callback url cant be empty');
        }

        $helper = $this->fb->getRedirectLoginHelper();
        $redirectUrl = $helper->getLoginUrl($callbackUrl,$this->options);
        $this->redirect($redirectUrl);
    }

    /**
     * @return SocialResponseInterface ;
     * @throws SocialAuthException
     * @throws SocialAuthResponseException
     */
    public function getSocialResponse()
    {
        $helper = $this->fb->getRedirectLoginHelper();
        try {
            $accessToken = $helper->getAccessToken();
        } catch(FacebookResponseException $e) {
            throw new SocialAuthResponseException($e);
        } catch(FacebookSDKException $e) {
            throw new SocialAuthResponseException($e);
        }catch (\Exception $e){
            throw new SocialAuthResponseException($e);
        }
        try {
            $fields = 'id,name,first_name,last_name,email,verified';
            $response = $this->fb->get('/me?fields='.$fields, $accessToken->getValue());
        } catch(FacebookResponseException $e) {
            throw new SocialAuthResponseException($e);
        } catch(FacebookSDKException $e) {
            throw new SocialAuthResponseException($e);
        }catch (\Exception $e){
            throw new SocialAuthResponseException($e);
        }
        $user = $response->getGraphUser();
        if ($user) {
            return new FacebookSocialResponse($user);
        }else{
            throw new SocialAuthException('Unable to get user profile from facebook');
        }
    }
    /**
     * @param string[] $options ;
     * @return SimpleSocialAuthInterface ;
     * @throws SocialAuthInvalidParams
     */
    public function setOptions(array $options)
    {
        if ( is_array($options) ) {
            $this->options = $options;
        }else{
            throw new SocialAuthInvalidParams('Options must be an array');
        }
        return $this;
    }
}
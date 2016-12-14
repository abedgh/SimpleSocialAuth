<?php
/**
 * Created by PhpStorm.
 * User: abed
 * Date: 12/12/16
 * Time: 6:25 PM
 */

namespace Asg\SimpleSocialAuth\Providers\Facebook;

use Facebook\Facebook;
use Facebook\Exceptions\FacebookSDKException;
use Facebook\Exceptions\FacebookResponseException;
use Asg\SimpleSocialAuth\Providers\BaseProvider;
use Asg\SimpleSocialAuth\Exceptions\SocialAuthException;
use Asg\SimpleSocialAuth\Exceptions\SocialAuthInvalidParams;
use Asg\SimpleSocialAuth\Exceptions\SocialAuthResponseException;
use Asg\SimpleSocialAuth\Providers\Contracts\SimpleSocialAuthInterface;
use Asg\SimpleSocialAuth\Providers\Contracts\SocialResponseInterface;

class FacebookProvider extends BaseProvider{


    protected $providerId = 1;
    protected $providerName = 'FACEBOOK';

    /**
     * @var \Facebook\Facebook
     * */
    protected $fb = null;

    function __construct($config){
        parent::__construct($config);
        $id = $this->getConfigKeyId();
        $secret = $this->getConfigKeySecret();

        if ($id != null && $secret != null) {
            if (session_status() != PHP_SESSION_ACTIVE) {
                session_start();
            }
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
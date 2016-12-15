<?php
/**
 * Created by PhpStorm.
 * User: abed
 * Date: 12/14/16
 * Time: 8:21 PM
 */

namespace Asg\SimpleSocialAuth\Providers\GooglePlus;


use Asg\SimpleSocialAuth\Exceptions\SocialAuthException;
use Asg\SimpleSocialAuth\Exceptions\SocialAuthResponseException;
use Asg\SimpleSocialAuth\Providers\BaseProvider;
use Asg\SimpleSocialAuth\Storage\Contracts\StorageInterface;
use Asg\SimpleSocialAuth\Exceptions\SocialAuthInvalidParams;
use Asg\SimpleSocialAuth\Providers\Contracts\SocialResponseInterface;

class GooglePlusProvider extends BaseProvider{

    protected $providerId = 3;
    protected $providerName = 'GooglePlus';

    protected $sessionStorage = null;
    protected $googleClient = null;

    function __construct(array $config,StorageInterface $sessionStorage = null ){
        parent::__construct($config);

        $id = $this->getConfigKeyId();
        $secret = $this->getConfigKeySecret();

        if ($sessionStorage == null){
            $this->sessionStorage = $this->getDefaultSessionStorage($this->getProviderName());
        }

        if ($id != null && $secret != null) {

            $this->googleClient = new \Google_Client();
            if ($this->googleClient) {
                $this->googleClient->setClientId($id);
                $this->googleClient->setClientSecret($secret);
                $this->googleClient->setAccessType('online');
            }else{
                throw new SocialAuthException('Unable to create Google_Client instance');
            }
        }else{
            throw new SocialAuthInvalidParams('Invalid Google Plus config');
        }
    }

    /**
     * @param string $callbackUrl ;
     * @throws SocialAuthException
     * @throws SocialAuthInvalidParams
     */
    public function login($callbackUrl = '')
    {
        $callbackUrl = !empty($callbackUrl)?$callbackUrl:$this->getCallbackUrl();
        if ($callbackUrl == '' || $callbackUrl == null){
            throw new SocialAuthInvalidParams('Callback url cant be empty');
        }
        if ($this->googleClient) {
            $this->sessionStorage->set('callbackUrl', $callbackUrl);
            $this->googleClient->setRedirectUri($callbackUrl);
            $this->googleClient->setScopes($this->options);
            $this->redirect($this->googleClient->createAuthUrl());
        }else{
            throw new SocialAuthException('Google_Client instance is null');
        }
    }

    /**
     * @return SocialResponseInterface ;
     * @throws SocialAuthException
     * @throws SocialAuthResponseException
     */
    public function getSocialResponse()
    {
        if ( isset($_GET['code']) ){
            $code = $_GET['code'];
            try {
                $googlePlus = new \Google_Service_Plus($this->googleClient);
                $this->googleClient->setRedirectUri($this->sessionStorage->get('callbackUrl'));
                $this->googleClient->authenticate($code);
                $token = json_decode($this->googleClient->getAccessToken());
                $attributes = $this->googleClient->verifyIdToken($token->id_token)
                    ->getAttributes();

                $user = $googlePlus->people->get('me');
                if ( isset($attributes['payload']['email_verified']) ){
                    $user->setVerified($attributes['payload']['email_verified']);
                }
                $this->sessionStorage->clear();
                return new GooglePlusSocialResponse($user);
            }catch (\Google_Auth_Exception $e){
                throw new SocialAuthResponseException($e);
            }catch (\Exception $e) {
                throw new SocialAuthResponseException($e);
            }
        }else{
            throw new SocialAuthException('Google auth code is missing');
        }
    }
}
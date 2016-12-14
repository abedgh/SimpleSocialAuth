<?php
/**
 * Created by PhpStorm.
 * User: abed
 * Date: 12/13/16
 * Time: 1:18 PM
 */

namespace Asg\SimpleSocialAuth\Providers\Twitter;


use Abraham\TwitterOAuth\TwitterOAuth;
use Abraham\TwitterOAuth\TwitterOAuthException;
use Asg\SimpleSocialAuth\Providers\BaseProvider;
use Asg\SimpleSocialAuth\Storage\SessionStorage;
use Asg\SimpleSocialAuth\Storage\Contracts\StorageInterface;
use Asg\SimpleSocialAuth\Exceptions\SocialAuthInvalidParams;
use Asg\SimpleSocialAuth\Exceptions\SocialAuthResponseException;
use Asg\SimpleSocialAuth\Providers\Contracts\SocialResponseInterface;

class TwitterProvider extends BaseProvider{


    protected $providerId = 2;
    protected $providerName = 'Twitter';

    /**
     * @var StorageInterface;
     * */
    protected $sessionStorage;

    function __construct($config,StorageInterface $sessionStorage = null){
        parent::__construct($config);
        if ($sessionStorage == null){
            $this->sessionStorage = new SessionStorage();
        }
    }

    /**
     * @param string $callbackUrl ;
     * @throws SocialAuthInvalidParams
     * @throws SocialAuthResponseException
     * @throws \Abraham\TwitterOAuth\TwitterOAuthException
     */
    public function login($callbackUrl = '')
    {
        $callbackUrl = !empty($callbackUrl)?$callbackUrl:$this->getCallbackUrl();
        if ($callbackUrl == '' || $callbackUrl == null){
            throw new SocialAuthInvalidParams('Callback url cant be empty');
        }
        $twitter = $this->createTwitterOAuthInstance();
        $requestToken = $twitter->oauth('oauth/request_token',['oauth_callback'=>$callbackUrl]);
        if ( !isset($requestToken['oauth_token']) ) {
            throw new SocialAuthResponseException('Unable to connect to twitter server');
        }
        $this->sessionStorage->set('TWITTER_AUTH_TOKENS',$requestToken);
        $redirectUrl = $twitter->url('oauth/authenticate', ['oauth_token' => $requestToken['oauth_token']]);
        $this->redirect($redirectUrl);
    }

    /**
     * @return SocialResponseInterface ;
     * @throws SocialAuthInvalidParams
     * @throws SocialAuthResponseException
     */
    public function getSocialResponse()
    {
        $oAuthToken = isset($_GET['oauth_token'])?$_GET['oauth_token']:null;
        $oAuthVerifier = isset($_GET['oauth_verifier'])?$_GET['oauth_verifier']:null;
        $twitterTokens = $this->sessionStorage->get('TWITTER_AUTH_TOKENS');

        if ($oAuthToken != null && $oAuthVerifier != null && $twitterTokens != null) {
            $oAuthTokenSecret = $twitterTokens['oauth_token_secret'];
            $this->sessionStorage->clear();
            try {
                $requestToken = $this->createTwitterOAuthInstance($oAuthToken, $oAuthTokenSecret)->oauth('oauth/access_token',
                    ['oauth_verifier' => $oAuthVerifier]
                );

                $user = $this->createTwitterOAuthInstance($requestToken['oauth_token'], $requestToken['oauth_token_secret'])
                    ->get('account/verify_credentials', $this->options);

                return new TwitterSocialResponse($user);

            }catch (TwitterOAuthException $e){
                throw new SocialAuthResponseException('Error to get user details from twitter');
            }
        }else{
            throw new SocialAuthInvalidParams('Error to get user details from twitter');
        }
    }

    /**
     * @param string|null $oAuthToken
     * @param string|null $oAuthTokenSecret
     * @return TwitterOAuth
     * @throws SocialAuthInvalidParams
     */
    protected function createTwitterOAuthInstance($oAuthToken = null,$oAuthTokenSecret = null){
        $id = $this->getConfigKeyId();
        $secret = $this->getConfigKeySecret();

        if ($id != null && $secret != null) {
            return new TwitterOAuth(
                $id,$secret,$oAuthToken,$oAuthTokenSecret
            );
        }else{
            throw new SocialAuthInvalidParams('Invalid twitter config');
        }
    }
}
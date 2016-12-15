<?php
/**
 * Created by PhpStorm.
 * User: abed
 * Date: 12/14/16
 * Time: 8:21 PM
 */

namespace Asg\SimpleSocialAuth\Providers\GooglePlus;


use Asg\SimpleSocialAuth\Exceptions\SocialAuthInvalidParams;
use Asg\SimpleSocialAuth\Providers\BaseProvider;
use Asg\SimpleSocialAuth\Providers\Contracts\SocialResponseInterface;
use Asg\SimpleSocialAuth\Storage\Contracts\StorageInterface;
use Asg\SimpleSocialAuth\Storage\SessionStorage;

class GooglePlusProvider extends BaseProvider{

    protected $providerId = 3;
    protected $providerName = 'GooglePlus';

    protected $storage = null;
    protected $googlePlus = null;

    function __construct(array $config,StorageInterface $storage = null ){
        parent::__construct($config);

        $id = $this->getConfigKeyId();
        $secret = $this->getConfigKeySecret();

        if ($storage == null){
            $this->storage = new SessionStorage($this->providerName);
        }

        if ($id != null && $secret != null) {

            $this->googlePlus = new \Google_Client();
            $this->googlePlus->setClientId($id);
            $this->googlePlus->setClientSecret($secret);

        }else{
            throw new SocialAuthInvalidParams('Invalid Google Plus config');
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
        $this->googlePlus->setRedirectUri($callbackUrl);
        $token = json_decode($this->googlePlus->getAccessToken());

        print_r($token);
        echo "get here1";
    }
    /**
     * @return SocialResponseInterface;
     * */
    public function getSocialResponse()
    {

        return new GooglePlusSocialResponse(null);
    }
}
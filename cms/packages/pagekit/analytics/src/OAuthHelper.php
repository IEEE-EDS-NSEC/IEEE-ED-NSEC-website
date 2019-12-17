<?php

namespace Pagekit\Analytics;

use Pagekit\Application as App;


use OAuth\Common\Consumer\Credentials;
use OAuth\Common\Storage\Memory;
use OAuth\Common\Token\TokenInterface;
use OAuth\OAuth1\Token\StdOAuth1Token;
use OAuth\OAuth2\Token\StdOAuth2Token;
use OAuth\ServiceFactory;


class OAuthHelper
{
    protected $serviceFactory, $services;

    public function __construct()
    {
        $this->serviceFactory = new ServiceFactory();
    }

    /**
     * Open OAuth session and get new token
     *
     * @param  string $provider
     * @param $credentials
     * @param TokenInterface|bool $token
     * @param string $redirectUri
     * @param  array $scope
     * @return false|Service
     * @throws \Exception
     */
    public function create($provider, $credentials, $token = false, $redirectUri = '', $scope = array())
    {
        $provider = ucfirst(strtolower($provider));
        $storage = new Memory;

        if (!isset($credentials['client_id']) || !isset($credentials['client_secret'])) {
            throw new \Exception('Credentials not valid');
        }

        $credentials = new Credentials(
            $credentials['client_id'],
            $credentials['client_secret'],
            $redirectUri
        );

        if (!$service = $this->serviceFactory->createService($provider, $credentials, $storage, $scope)) {
            throw new \Exception('Could not create Service');
        }

        if ($token && $token = $this->arrayToToken($token)) {
            $storage->storeAccessToken($provider, $token);

            if ($token->getEndOfLife() < time()) {
                if ($token->getRefreshToken()) {
                    try {
                        $service->refreshAccessToken($token);
                    } catch (\Exception $e) {
                        throw new \Exception('Could not refresh Token');
                    }
                } else {
                    throw new \Exception('Token expired');
                }
            }
        }

        return $service;
    }

    /**
     * Create token object from array.
     *
     * @param array $data
     * @return TokenInterface
     */
    public function arrayToToken(array $data)
    {
        if ($data &&
            array_key_exists('accessToken', $data) &&
            array_key_exists('accessTokenSecret', $data) &&
            array_key_exists('requestToken', $data) &&
            array_key_exists('requestTokenSecret', $data) &&
            array_key_exists('endOfLife', $data) &&
            array_key_exists('extraParams', $data)
        ) {
            $token = new StdOAuth1Token($data['accessToken']);
            $token->setAccessTokenSecret($data['accessTokenSecret']);
            $token->setRequestToken($data['requestToken']);
            $token->setRequestTokenSecret($data['requestTokenSecret']);
            $token->setEndOfLife($data['endOfLife']);
            $token->setExtraParams($data['extraParams']);
        } elseif ($data &&
            array_key_exists('accessToken', $data) &&
            array_key_exists('refreshToken', $data) &&
            array_key_exists('endOfLife', $data) &&
            array_key_exists('extraParams', $data)
        ) {
            $token = new StdOAuth2Token($data['accessToken'], $data['refreshToken'], null, $data['extraParams']);
            $token->setEndOfLife($data['endOfLife']);
        }

        if (!isset($token) || !$token) {
            return null;
        }

        return $token;
    }

    /**
     * Convert token object into array.
     *
     * @param TokenInterface $token
     * @return array
     */
    public function tokenToArray(TokenInterface $token)
    {
        $data = array();

        if (get_class($token) === 'OAuth\OAuth1\Token\StdOAuth1Token') {
            $data['accessToken'] = $token->getAccessToken();
            $data['accessTokenSecret'] = $token->getAccessTokenSecret();
            $data['requestToken'] = $token->getRequestToken();
            $data['requestTokenSecret'] = $token->getRequestTokenSecret();
            $data['endOfLife'] = $token->getEndOfLife();
            $data['extraParams'] = $token->getExtraParams();
        } else {
            $data['accessToken'] = $token->getAccessToken();
            $data['refreshToken'] = $token->getRefreshToken();
            $data['endOfLife'] = $token->getEndOfLife();
            $data['extraParams'] = $token->getExtraParams();
        }

        return $data;
    }

    /**
     * @param $provider
     * @param $code
     * @param $credentials
     * @param $redirectUri
     * @param bool $token
     * @return bool
     * @throws \Exception
     */
    public function requestToken($provider, $code, $credentials, $redirectUri, $token = false)
    {
        $service = $this->create($provider, $credentials, $token, $redirectUri);

        switch ($service::OAUTH_VERSION) {
            case 1:

                //TODO: Implement authorization flow for OAuth 1

//                if ($oauth_token && $oauth_verifier) {
//                    $token = $service->storage->retrieveAccessToken($service->getClass());
//
//                    $token = $service->requestAccessToken(
//                        $oauth_token,
//                        $oauth_verifier,
//                        $token->getRequestTokenSecret()
//                    );
//
//                    if (!$token->getAccessToken()) {
//                        throw new \Exception("Couldn't retrieve token.");
//                    }
//                }

                break;

            case 2:
                $token = $service->requestAccessToken($code);

                break;
        }

        return $token;
    }
}

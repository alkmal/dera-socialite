<?php

namespace kimoetch\DeraSocialite;

use GuzzleHttp\RequestOptions;
use Illuminate\Support\Arr;
use SocialiteProviders\Manager\OAuth2\AbstractProvider;
use SocialiteProviders\Manager\OAuth2\User;

class Provider extends AbstractProvider
{
    /**
     * Unique Provider Identifier.
     */
    public const IDENTIFIER = 'dera';

    /**
     * {@inheritdoc}
     */
    protected $scopes = [
        'http://accounts.shieldit.sa/api/profile',
    ];


    public function __construct() {
        $this->scopes = env('DeraSocialite_ACCOUNTS_URL').'/api/profile';
    }


    /**
     * {@inheritdoc}
     */
    protected $scopeSeparator = ' ';

    /**
     * {@inheritdoc}
     */
    protected function getAuthUrl($state)
    {
        return $this->buildAuthUrlFromBase(env('DeraSocialite_ACCOUNTS_URL').'/api/login', $state);
    }

    /**
     * {@inheritdoc}
     */
    protected function getTokenUrl()
    {
        return env('DeraSocialite_ACCOUNTS_URL').'/api/token';
    }

    /**
     * {@inheritdoc}
     */
    protected function getUserByToken($token)
    {
        $response = $this->getHttpClient()->get(env('DeraSocialite_ACCOUNTS_URL').'/api/profile?', [
            RequestOptions::QUERY => [
//                RequestOptions::QUERY => '{me{externalId displayName bitmoji{avatar id}}}',
            ],
            RequestOptions::HEADERS => [
                'Authorization' => 'Bearer '.$token,
            ],
        ]);

        return json_decode((string) $response->getBody(), true);
    }

    /**
     * {@inheritdoc}
     */
    protected function mapUserToObject(array $user)
    {
        return (new User())->setRaw($user)->map([
            'id'       => Arr::get($user, 'id'),
            'name'     => Arr::get($user, 'name'),
            'email'     => Arr::get($user, 'email'),
            'avatar'   => Arr::get($user, 'avatar'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    protected function getTokenFields($code)
    {
        return array_merge(parent::getTokenFields($code), [
            'grant_type' => 'authorization_code',
        ]);
    }
}

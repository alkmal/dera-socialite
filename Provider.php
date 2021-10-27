<?php

namespace kimoetch\DeraSocialite;

use GuzzleHttp\RequestOptions;
use Illuminate\Support\Arr;
use kimoetch\Manager\OAuth2\AbstractProvider;
use kimoetch\Manager\OAuth2\User;

class Provider extends AbstractProvider
{
    /**
     * Unique Provider Identifier.
     */
    public const IDENTIFIER = 'DeraSocialite';

    /**
     * {@inheritdoc}
     */
    protected $scopes = [
        'http://accounts.shieldit.sa/api/user',
    ];

    /**
     * {@inheritdoc}
     */
    protected $scopeSeparator = ' ';

    /**
     * {@inheritdoc}
     */
    protected function getAuthUrl($state)
    {
        return $this->buildAuthUrlFromBase('https://accounts.shieldit.sa/api/login', $state);
    }

    /**
     * {@inheritdoc}
     */
    protected function getTokenUrl()
    {
        return 'https://accounts.shieldit.sa/api/token';
    }

    /**
     * {@inheritdoc}
     */
    protected function getUserByToken($token)
    {
        $response = $this->getHttpClient()->get('https://accounts.shieldit.sa/v1/profile?', [
            RequestOptions::QUERY => [
                RequestOptions::QUERY => '{me{externalId displayName bitmoji{avatar id}}}',
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
            'id'       => Arr::get($user, 'data.user.id'),
            'name'     => Arr::get($user, 'data.user.name'),
            'avatar'   => Arr::get($user, 'data.user.avatar'),
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
<?php

namespace kimoetch\DeraSocialite;

use SocialiteProviders\Manager\SocialiteWasCalled;

class DeraSocialiteExtendSocialite
{
    /**
     * Register the provider.
     *
     * @param \kimoetch\Manager\SocialiteWasCalled $socialiteWasCalled
     */
    public function handle(SocialiteWasCalled $socialiteWasCalled)
    {
        $socialiteWasCalled->extendSocialite('dera', Provider::class);
    }
}

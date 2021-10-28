<?php

namespace kimoetch\DeraSocialite;

use kimoetch\Manager\SocialiteWasCalled;

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

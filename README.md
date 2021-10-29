# DeraSocialite

```bash
composer require kimoetch/dera-socialite
```

## Installation & Basic Usage

Please see the [Base Installation Guide](https://kimoetch.com/usage/), then follow the provider specific instructions below.

### Add configuration to `config/services.php`

```php
'DeraSocialite' => [    
  'client_id' => env('DeraSocialite_CLIENT_ID'),  
  'client_secret' => env('DeraSocialite_CLIENT_SECRET'),  
  'redirect' => env('DeraSocialite_REDIRECT_URI') 
],
```

### Add provider event listener

Configure the package's listener to listen for `SocialiteWasCalled` events.

Add the event to your `listen[]` array in `app/Providers/EventServiceProvider`. See the [Base Installation Guide](https://kimoetch.com/usage/) for detailed instructions.

```php
protected $listen = [
    \kimoetch\Manager\SocialiteWasCalled::class => [
        // ... other providers
        \kimoetch\DeraSocialite\DeraSocialiteExtendSocialite::class.'@handle',
    ],
];
```

### Usage

You should now be able to use the provider like you would regularly use Socialite (assuming you have the facade installed):

```php
return Socialite::driver('DeraSocialite')->redirect();
```

### Returned User fields

- ``id``
- ``name``
- ``avatar``

ohmy-auth [![Build Status](https://travis-ci.org/sudocode/ohmy-auth.png?branch=master)](https://travis-ci.org/sudocode/ohmy-auth)
========

ohmy-auth (Oma) is a PHP library that simplifies the OAuth flow using [promises](http://en.wikipedia.org/wiki/Futures_and_promises). Currently Oma only supports 2-legged and 3-legged OAuth 1.0a.

### Dependencies

Oma only requires PHP (>= 5.3.0) and the Curl extension.

### Two-Legged OAuth 1.0a 

```php
use ohmy\Auth1;

# 2-legged oauth
Auth1::init(2)
    ->set('key', 'key')
    ->set('secret', 'secret')
    ->request('http://term.ie/oauth/example/request_token.php')
    ->access('http://term.ie/oauth/example/access_token.php')
    ->then(function($data) {
        # dump access token
        var_dump($data);
    });
```

### Three-Legged OAuth 1.0a

```php
use ohmy\Auth1;

# start session for saving data in between redirects
session_start();

# 3-legged oauth
Auth1::init(3, array(
        'consumer_key'    => 'YOUR_CONSUMER_KEY',
        'consumer_secret' => 'YOUR_CONSUMER_SECRET',
        'callback'        => 'YOUR_OAUTH_CALLBACK_URL'
    ))
    ->request('http://www.tumblr.com/oauth/request_token')
    ->authorize('http://www.tumblr.com/oauth/authorize')
    ->access('http://www.tumblr.com/oauth/access_token') 
    ->then(function($data) {
        # dump access token
        var_dump($data);
        # destroy session data
        session_destroy();
    });
```

### Licenses

__PHP license__: PHP License

__pecl_http license__: BSD, revised

__ohmyAuth__: New BSD License.

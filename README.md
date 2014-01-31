ohmy-auth [![Build Status](httphttps://github.com/sudocode/ohmy-auth/edit/master/README.md#s://travis-ci.org/sudocode/ohmy-auth.png?branch=master)](https://travis-ci.org/sudocode/ohmy-auth)
========

ohmy-auth (Oma) is a PHP library that simplifies the OAuth flow using [promises](http://en.wikipedia.org/wiki/Futures_and_promises). Currently Oma supports 2-legged and 3-legged OAuth 1.0a and 3-legged Oauth 2.0.

### Dependencies
Oma only requires PHP (>= 5.3.0) and the Curl extension. 

### Installing with Composer
The best way to install Oma is via Composer. Just add ```ohmy/auth``` to your project's ```composer.json``` and run ```composer install```. eg:
```json
{
    "require": {
        "ohmy/auth": "*"
    }
}
```

### Installing manually
If you prefer not to use Composer, you can download an archive or clone this repo and put ```src/ohmy``` into your project setup. 

### Two-Legged OAuth 1.0a 
```php
use ohmy\Auth1;

# do 2-legged oauth
$termie = Auth1::init(2)
               # configuration
               ->set('key', 'key')
               ->set('secret', 'secret')
               # oauth flow
               ->request('http://term.ie/oauth/example/request_token.php')
               ->access('http://term.ie/oauth/example/access_token.php');

# api call
$termie->GET('http://term.ie/oauth/example/echo_api.php')
       ->then(function($data) {
           # got data
       });
```

### Three-Legged OAuth 1.0a
```php
use ohmy\Auth1;

# start session for saving data in between redirects
session_start();

# do 3-legged oauth
$tumblr = Auth1::init(3)
               # configuration
               ->set('consumer_key', 'your_consumer_key')
               ->set('consumer_secret', 'your_consumer_secret')
               ->set('callback', 'your_callback_url');
               # oauth flow
               ->request('http://www.tumblr.com/oauth/request_token')
               ->authorize('http://www.tumblr.com/oauth/authorize')
               ->access('http://www.tumblr.com/oauth/access_token') 
               ->then(function($data) {
                    session_destroy();
               });

# access tumblr api      
$tumblr->GET('https://api.tumblr.com/v2/user/info')
       ->then(function($data) {
           # got user data
       });
```

### Three-Legged OAuth 2.0
```php
use ohmy\Auth2;

# do 3-legged oauth
$github = Auth2::init(3)
               # configuration
               ->set('id', 'your_github_client_id')
               ->set('secret', 'your_github_client_secret')
               ->set('redirect', 'your_redirect_uri');
               # oauth flow
               ->authorize('https://github.com/login/oauth/authorize')
               ->access('https://github.com/login/oauth/access_token');

# access github api
$github->GET('https://api.github.com/user', null, array('User-Agent' => 'ohmy-auth'))
       ->then(function($data) {
           # got user data
       });
```

### Licenses
 - __PHP license__: PHP License
 - __ohmy-auth__: New BSD License.

<?php require_once __DIR__ . '/../vendor/autoload.php';

use ohmy\Auth1;


Auth1::init(3)
    ->set('oauth_consumer_key', '')
    ->set('oauth_consumer_secret', '')
    ->set('oauth_callback', 'YOUR_OAUTH_CALLBACK_URL')
    ->request('http://www.tumblr.com/oauth/request_token')
    ->authorize('http://www.tumblr.com/oauth/authorize')
    ->access('http://www.tumblr.com/oauth/access_token', function($data) {
        var_dump($data);
    });

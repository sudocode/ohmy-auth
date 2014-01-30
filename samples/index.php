<?php require_once __DIR__ . '/../vendor/autoload.php';

use ohmy\Auth1;


Auth1::init(2)
    ->set('oauth_consumer_key', 'key')
    ->set('oauth_consumer_secret', 'secret')
    ->request('http://term.ie/oauth/example/request_token.php')
    ->access('http://term.ie/oauth/example/access_token.php')
    ->then(function($data) {
        echo 'got data</br>';
        var_dump($data);
    });

echo 'done';


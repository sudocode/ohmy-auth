<?php require_once __DIR__ . '/../vendor/autoload.php';

/*
 * Copyright (c) 2014, Yahoo! Inc. All rights reserved.
 * Copyrights licensed under the New BSD License.
 * See the accompanying LICENSE file for terms.
 */

use ohmy\Auth1;


# initialize 2-legged oauth
$termie = Auth1::legs(2)
               ->set('oauth_consumer_key', 'key')
               ->set('oauth_consumer_secret', 'secret')
               ->request('http://term.ie/oauth/example/request_token.php')
               ->access('http://term.ie/oauth/example/access_token.php')
               ->finally(function($data) use(&$token, &$secret) {
                   $token = $data['oauth_token'];
                   $secret = $data['oauth_token_secret'];
               });

# test GET call
$termie->GET('http://term.ie/oauth/example/echo_api.php?method=get')
       ->then(function($response) {
            var_dump($response->text());
        });

# test POST call
$termie->POST('http://term.ie/oauth/example/echo_api.php', array('method' => 'post'))
       ->then(function($response) {
            var_dump($response->text());
        });


# test revival
$termie2 = Auth1::init(2)
                ->set('oauth_consumer_key', 'key')
                ->set('oauth_consumer_secret', 'secret')
                ->access($token, $secret)
                ->GET('http://term.ie/oauth/example/echo_api.php?method=revive')
                ->then(function($response) {
                    var_dump($response->text());
                });

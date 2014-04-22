<?php require_once __DIR__ . '/../vendor/autoload.php';

/*
 * Copyright (c) 2014, Yahoo! Inc. All rights reserved.
 * Copyrights licensed under the New BSD License.
 * See the accompanying LICENSE file for terms.
 */

use ohmy\Auth;


# initialize OAuth1 2-legged
$termie = Auth::init(array(
                  'oauth_consumer_key'    => 'key',
                  'oauth_consumer_secret' => 'secret',
              ))

              # oauth flow
              ->request('http://term.ie/oauth/example/request_token.php')
              ->access('http://term.ie/oauth/example/access_token.php')

              # save data
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
$termie2 = Auth::init(array(
                    'oauth_consumer_key'    => 'key',
                    'oauth_consumer_secret' => 'secret',
                ))

                # oauth flow
                ->access($token, $secret)

                # view data
                ->GET('http://term.ie/oauth/example/echo_api.php?method=revive')
                ->then(function($response) {
                    var_dump($response->text());
                });

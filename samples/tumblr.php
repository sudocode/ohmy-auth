<?php require_once __DIR__ . '/../vendor/autoload.php';

/*
 * Copyright (c) 2014, Yahoo! Inc. All rights reserved.
 * Copyrights licensed under the New BSD License.
 * See the accompanying LICENSE file for terms.
 */

use ohmy\Auth1;

# start a session to save oauth data in-between redirects
session_start();

# initialize 3-legged oauth
Auth1::init(3)
    ->set('key', 'YOUR_CONSUMER_KEY')
    ->set('secret', 'YOUR_CONSUMER_SECRET')
    ->set('callback', 'YOUR_OAUTH_CALLBACK_URL')
    ->request('http://www.tumblr.com/oauth/request_token')
    ->authorize('http://www.tumblr.com/oauth/authorize')
    ->access('http://www.tumblr.com/oauth/access_token', function($data) {
          var_dump($data);
    });


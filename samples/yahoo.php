<?php require_once __DIR__ . '/../vendor/autoload.php';

/*
 * Copyright (c) 2014, Yahoo! Inc. All rights reserved.
 * Copyrights licensed under the New BSD License.
 * See the accompanying LICENSE file for terms.
 */

use ohmy\Auth;

# start a session to save oauth data in-between redirects
session_start();

# initialize 3-legged oauth
Auth::init(3)

    # set your consumer key
    ->set('key', 'YOUR_CONSUMER_KEY')

    # set your consumer secret
    ->set('secret', 'YOUR_CONSUMER_SECRET')

    # set your oauth callback url
    ->set('callback', 'YOUR_CALLBACK')

    # 1st leg.. get request token
    ->leg('https://api.login.yahoo.com/oauth/v2/get_request_token')

    # 2nd leg.. redirect user to yahoo
    ->leg('https://api.login.yahoo.com/oauth/v2/request_auth')

    # 3rd leg.. get access token
    ->leg('https://api.login.yahoo.com/oauth/v2/get_token', function($data) {

        var_dump($data);

    });
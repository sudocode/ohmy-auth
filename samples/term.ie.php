<?php require_once __DIR__ . '/../vendor/autoload.php';

/*
 * Copyright (c) 2014, Yahoo! Inc. All rights reserved.
 * Copyrights licensed under the New BSD License.
 * See the accompanying LICENSE file for terms.
 */

use ohmy\Auth;


# initialize 2-legged oauth
Auth::init(2)

    # set key/secret
    ->set('key', 'key')
    ->set('secret', 'secret')

    # 1st leg.. get request token
    ->leg('http://term.ie/oauth/example/request_token.php')

    # 2nd leg.. get acesss token
    ->leg('http://term.ie/oauth/example/access_token.php', function($data) {

          # dump access token
          var_dump($data);

    });


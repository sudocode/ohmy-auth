<?php require_once __DIR__ . '/../vendor/autoload.php';

/*
 * Copyright (c) 2014, Yahoo! Inc. All rights reserved.
 * Copyrights licensed under the New BSD License.
 * See the accompanying LICENSE file for terms.
 */

use ohmy\Auth1;


# initialize 2-legged oauth
Auth1::init(2)
     ->set('oauth_consumer_key', 'key')
     ->set('oauth_consumer_secret', 'secret')
     ->request('http://term.ie/oauth/example/request_token.php')
     ->access('http://term.ie/oauth/example/access_token.php')
     ->then(function($data) {
         var_dump($data);
     });


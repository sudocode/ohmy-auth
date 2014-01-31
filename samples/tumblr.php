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
$tumblr = Auth1::init(3)
               # configuration
               ->set('key', 'your tumblr consumer key')
               ->set('secret', 'your tumblr consumer secret')
               ->set('callback', 'your callback url')

               # oauth flow
               ->request('http://www.tumblr.com/oauth/request_token')
               ->authorize('http://www.tumblr.com/oauth/authorize')
               ->access('http://www.tumblr.com/oauth/access_token')
               ->then(function($data) {
                   # destroy session
                   session_destroy();
               });
    
# test GET method
$tumblr->GET('https://api.tumblr.com/v2/user/info')
       ->then(function($data) {
          var_dump($data);
       });


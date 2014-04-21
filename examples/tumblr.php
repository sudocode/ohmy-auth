<?php require_once __DIR__ . '/../vendor/autoload.php';

/*
 * Copyright (c) 2014, Yahoo! Inc. All rights reserved.
 * Copyrights licensed under the New BSD License.
 * See the accompanying LICENSE file for terms.
 */

use ohmy\Auth;

# initialize OAuth1 3-legged
$tumblr = Auth::init(array(
                  'key'      => 'your consumer key',
                  'secret'   => 'your consumer secret',
                  'callback' => 'your callback url'
              ))

              # oauth flow
              ->request('http://www.tumblr.com/oauth/request_token')
              ->authorize('http://www.tumblr.com/oauth/authorize')
              ->access('http://www.tumblr.com/oauth/access_token');

# test GET method
$tumblr->GET('https://api.tumblr.com/v2/user/info')
       ->then(function($response) {
          echo '<pre>';
          var_dump($response->json());
          echo '</pre>';
       });


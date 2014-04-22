<?php require_once __DIR__ . '/../vendor/autoload.php';

/*
 * Copyright (c) 2014, Yahoo! Inc. All rights reserved.
 * Copyrights licensed under the New BSD License.
 * See the accompanying LICENSE file for terms.
 */

use ohmy\Auth;

# initialize OAuth1 3-legged
$yahoo = Auth::init(array(
                  'key'      => 'your consumer key',
                  'secret'   => 'your consumer secret',
                  'callback' => 'your callback url'
              ))

              # oauth
              ->request('https://api.login.yahoo.com/oauth/v2/get_request_token')
              ->authorize('https://api.login.yahoo.com/oauth/v2/request_auth')
              ->access('https://api.login.yahoo.com/oauth/v2/get_token');

$yahoo->GET('https://query.yahooapis.com/v1/yql?q=select%20*%20from%20social.contacts%20where%20guid%3Dme%3B&format=json&diagnostics=true&callback=')
      ->then(function($response) {
          echo '<pre>';
          var_dump($response->json());
          echo '</pre>';
      });

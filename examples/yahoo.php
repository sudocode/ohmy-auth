<?php require_once __DIR__ . '/../vendor/autoload.php';

/*
 * Copyright (c) 2014, Yahoo! Inc. All rights reserved.
 * Copyrights licensed under the New BSD License.
 * See the accompanying LICENSE file for terms.
 */

use ohmy\Auth1;
use ohmy\OhmyAuth;


# initialize 3-legged oauth
$yahoo = OhmyAuth::init(new Auth1, 3)
              ->set('key', 'your consumer key')
              ->set('secret', 'your consumer secret')
              ->set('callback', 'your callback')

              # oauth
              ->request('https://api.login.yahoo.com/oauth/v2/get_request_token')
              ->authorize('https://api.login.yahoo.com/oauth/v2/request_auth')
              ->access('https://api.login.yahoo.com/oauth/v2/get_token');

$yahoo->GET('http://social.yahooapis.com/v1/me/guid?format=json')
      ->then(function($response) {
          echo '<pre>';
          var_dump($response->json());
          echo '</pre>';
      });

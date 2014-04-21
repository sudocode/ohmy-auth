<?php require_once __DIR__ . '/../vendor/autoload.php';

/*
 * Copyright (c) 2014, Yahoo! Inc. All rights reserved.
 * Copyrights licensed under the New BSD License.
 * See the accompanying LICENSE file for terms.
 */

use ohmy\Auth;

# initialize OAuth2 3-legged
$github = Auth::init(array(
                  'id'       => 'your client id',
                  'secret'   => 'your client secret',
                  'redirect' => 'your redirect uri'
              ))

              # oauth
              ->authorize('https://github.com/login/oauth/authorize')
              ->access('https://github.com/login/oauth/access_token')

              # save access token
              ->finally(function($data) use(&$access_token) {
                 $access_token = $data['access_token'];
              });

# access github api
$github->GET("https://api.github.com/user?access_token=$access_token", null, array('User-Agent' => 'ohmy-auth'))
       ->then(function($response) {
           echo '<pre>';
           var_dump($response->json());
           echo '</pre>';
       });

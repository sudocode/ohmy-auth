<?php require_once __DIR__ . '/../vendor/autoload.php';

/*
 * Copyright (c) 2014, Yahoo! Inc. All rights reserved.
 * Copyrights licensed under the New BSD License.
 * See the accompanying LICENSE file for terms.
 */

use ohmy\Auth;

# initialize OAuth2 3-legged
$google = Auth::init(array(
                  'id'       => 'your client id',
                  'secret'   => 'your client secret',
                  'redirect' => 'your redirect uri',
                  'scope'    => 'profile'
              ))

              # oauth flow
              ->authorize('https://accounts.google.com/o/oauth2/auth')
              ->access('https://accounts.google.com/o/oauth2/token')

              # save access token
              ->finally(function($data) use(&$access_token) {
                 $access_token = $data['access_token'];
              });

# test GET call
$google->GET("https://www.googleapis.com/plus/v1/people/me?access_token=$access_token")
       ->then(function($response) {
           echo '<pre>';
           var_dump($response->text);
           echo '</pre>';
       });


<?php require_once __DIR__ . '/../vendor/autoload.php';

/*
 * Copyright (c) 2014, Yahoo! Inc. All rights reserved.
 * Copyrights licensed under the New BSD License.
 * See the accompanying LICENSE file for terms.
 */

use ohmy\Auth;

# initialize OAuth2 3-legged
$instagram = Auth::init(array(
                      'id'       => 'your client id',
                      'secret'   => 'your client secret',
                      'redirect' => 'your redirect uri',
                      'scope'    => 'basic'
                  ))

                  # oauth flow
                  ->authorize('https://api.instagram.com/oauth/authorize')
                  ->access('https://api.instagram.com/oauth/access_token')

                  # save data
                  ->finally(function($data) use(&$access_token) {
                      $access_token = $data['access_token'];
                  });

# test GET call
$instagram->GET("https://api.instagram.com/v1/users/self/feed/?access_token=$access_token")
          ->then(function($response) {
              echo '<pre>';
              var_dump($response->json());
              echo '</pre>';
          });


<?php require_once __DIR__ . '/../vendor/autoload.php';

/*
 * Copyright (c) 2014, Yahoo! Inc. All rights reserved.
 * Copyrights licensed under the New BSD License.
 * See the accompanying LICENSE file for terms.
 */

use ohmy\Auth2;

# initialize 3-legged oauth
$instagram = Auth2::init(3);

# configuration
$instagram->set('id', 'your client id')
          ->set('secret', 'your client secret')
          ->set('redirect', 'your redirect uri')
          ->set('scope', 'wl.basic');

# oauth flow
$instagram = $instagram->authorize('https://login.live.com/oauth20_authorize.srf')
                       ->access('https://login.live.com/oauth20_token.srf')
                       ->then(function($data) use(&$access_token) {
                           $access_token = $data['access_token'];
                       });

# test GET call
$instagram->GET("https://apis.live.net/v5.0/me?access_token=$access_token")
          ->then(function($response) {
              echo '<pre>';
              var_dump($response->json());
              echo '</pre>';
          });


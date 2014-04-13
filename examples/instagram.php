<?php require_once __DIR__ . '/../vendor/autoload.php';

/*
 * Copyright (c) 2014, Yahoo! Inc. All rights reserved.
 * Copyrights licensed under the New BSD License.
 * See the accompanying LICENSE file for terms.
 */

use ohmy\Auth2;

# initialize 3-legged oauth
$instagram = Auth2::legs(3)
                  ->set('id', 'your client id')
                  ->set('secret', 'your client secret')
                  ->set('redirect', 'your redirect uri')
                  ->set('scope', 'basic')

                  # oauth flow
                  ->authorize('https://api.instagram.com/oauth/authorize')
                  ->access('https://api.instagram.com/oauth/access_token')
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


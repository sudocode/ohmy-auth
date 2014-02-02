<?php require_once __DIR__ . '/../vendor/autoload.php';

/*
 * Copyright (c) 2014, Yahoo! Inc. All rights reserved.
 * Copyrights licensed under the New BSD License.
 * See the accompanying LICENSE file for terms.
 */

use ohmy\Auth2;

# initialize 3-legged oauth
$google = Auth2::init(3);

# configuration
$google->set('id', 'your client id')
       ->set('secret', 'your client secret')
       ->set('redirect', 'your redirect uri')
       ->set('scope', 'profile');

# oauth flow
$google = $google->authorize('https://accounts.google.com/o/oauth2/auth')
                 ->access('https://accounts.google.com/o/oauth2/token')
                 ->then(function($data) use(&$access_token) {
                     $access_token = $data['access_token'];
                 });

# test GET call
$google->GET("https://www.googleapis.com/plus/v1/people/me?access_token=$access_token")
       ->then(function($response) {
           echo '<pre>';
           var_dump($response->text);
           echo '</pre>';
       });


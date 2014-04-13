<?php require_once __DIR__ . '/../vendor/autoload.php';

/*
 * Copyright (c) 2014, Yahoo! Inc. All rights reserved.
 * Copyrights licensed under the New BSD License.
 * See the accompanying LICENSE file for terms.
 */

use ohmy\Auth2;

# initialize 3-legged oauth
$facebook = Auth2::legs(3)
                 ->set(array(
                    'id'       => 'your client id',
                    'secret'   => 'your client secret',
                    'redirect' => 'your redirect uri',
                    'scope'    => 'read_stream'
                 ))

                 # oauth flow
                 ->authorize('https://www.facebook.com/dialog/oauth')
                 ->access('https://graph.facebook.com/oauth/access_token')
                 ->finally(function($data) use(&$access_token) {
                     $access_token = $data['access_token'];
                 });

# test GET call
$facebook->GET("https://graph.facebook.com/me/home?access_token=$access_token")
         ->then(function($response) {
             echo '<pre>';
             var_dump($response->json());
             echo '</pre>';
         });


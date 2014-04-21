<?php require_once __DIR__ . '/../vendor/autoload.php';

/*
 * Copyright (c) 2014, Yahoo! Inc. All rights reserved.
 * Copyrights licensed under the New BSD License.
 * See the accompanying LICENSE file for terms.
 */

use ohmy\Auth;

# initialize OAuth2 3-legged
$linkedin = Auth::init(array(
                      'id'       => 'your client id',
                      'secret'   => 'your client secret',
                      'redirect' => 'your redirect uri'
                  ))

                 # oauth flow
                 ->authorize('https://www.linkedin.com/uas/oauth2/authorization')
                 ->access('https://www.linkedin.com/uas/oauth2/accessToken')

                 # save data
                 ->finally(function($data) use(&$access_token) {
                     $access_token = $data['access_token'];
                 });

# test GET call
$linkedin->GET("https://api.linkedin.com/v1/people/~?oauth2_access_token=$access_token")
         ->then(function($response) {
             echo '<pre>';
             var_dump($response->text);
             echo '</pre>';
         });


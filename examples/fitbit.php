<?php require_once __DIR__ . '/../vendor/autoload.php';

/*
 * Copyright (c) 2014, Yahoo! Inc. All rights reserved.
 * Copyrights licensed under the New BSD License.
 * See the accompanying LICENSE file for terms.
 */

use ohmy\Auth1;

# initialize 3-legged oauth
$fitbit = Auth1::legs(3)
               ->set('key', 'your consumer key')
               ->set('secret', 'your consumer secret')
               ->set('callback', 'your callback url')

               # oauth
               ->request('http://api.fitbit.com/oauth/request_token')
               ->authorize('http://www.fitbit.com/oauth/authorize')
               ->access('http://api.fitbit.com/oauth/access_token')

               # save user id
               ->finally(function($data) use(&$user_id) {
                    $user_id = $data['encoded_user_id'];
               });

# test GET call
$fitbit->GET("https://api.fitbit.com/1/user/$user_id/profile.json")
       ->then(function($response) {
           echo '<pre>';
           var_dump($response->json());
           echo '</pre>';
       });


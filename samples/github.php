<?php require_once __DIR__ . '/../vendor/autoload.php';

/*
 * Copyright (c) 2014, Yahoo! Inc. All rights reserved.
 * Copyrights licensed under the New BSD License.
 * See the accompanying LICENSE file for terms.
 */

use ohmy\Auth2;

Auth2::init(3)

     # configuration
     ->set('id', 'your client id')
     ->set('secret', 'your client secret')
     ->set('redirect', 'your callback url')

     # oauth steps
     ->authorize('https://github.com/login/oauth/authorize')
     ->access('https://github.com/login/oauth/access_token')

     # access github api
     ->GET('https://api.github.com/user', null, array('User-Agent' => 'ohmy-auth'))
     ->then(function($response) {
           echo '<pre>';
           var_dump($response->json());
           echo '</pre>';
      });

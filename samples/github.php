<?php require_once __DIR__ . '/../vendor/autoload.php';

/*
 * Copyright (c) 2014, Yahoo! Inc. All rights reserved.
 * Copyrights licensed under the New BSD License.
 * See the accompanying LICENSE file for terms.
 */

use ohmy\Auth2;

Auth2::init(3)

     # configuration
     ->set('id', 'your github client id')
     ->set('secret', 'your github client secret')
     ->set('redirect', 'your redirect uri')

     # oauth steps
     ->authorize('https://github.com/login/oauth/authorize')
     ->access('https://github.com/login/oauth/access_token')

     # access github api
     ->GET('https://api.github.com/user', null, array('User-Agent' => 'ohmy-auth'))
     ->then(function($data) {
           echo '<pre>';
           var_dump(json_decode($data));
           echo '</pre>';
      });

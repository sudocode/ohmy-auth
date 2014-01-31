<?php require_once __DIR__ . '/vendor/autoload.php';

/*
 * Copyright (c) 2014, Yahoo! Inc. All rights reserved.
 * Copyrights licensed under the New BSD License.
 * See the accompanying LICENSE file for terms.
 */

use ohmy\Auth2,
    ohmy\Auth2\Flow\ThreeLegged,
    ohmy\Http\Curl;


$github = new ThreeLegged(function($resolve) {
    $resolve(array(
        'client_id'    => '',
        'client_secret' => '',
        'redirect_uri' => '',
        'scope'        => '',
        'state'        => '',
        'code'         => $_REQUEST['code']
    ));
}, new Curl);

$github->authorize('https://github.com/login/oauth/authorize')
       ->access('https://github.com/login/oauth/access_token')
       ->GET('https://api.github.com/user', null, array('User-Agent' => 'Test'))
       ->then(function($data) {
           echo '<pre>';
           var_dump($data);
           echo '</pre>';
       });

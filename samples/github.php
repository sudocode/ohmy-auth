<?php require_once __DIR__ . '/../vendor/autoload.php';

/*
 * Copyright (c) 2014, Yahoo! Inc. All rights reserved.
 * Copyrights licensed under the New BSD License.
 * See the accompanying LICENSE file for terms.
 */

use ohmy\Auth2,
    ohmy\Auth2\Flow\ThreeLegged;


$github = new ThreeLegged(function($resolve) {
    $resolve(array(
        'client_id'    => '',
        'redirect_uri' => '',
        'scope'        => '',
        'state'        => ''
    ));
});


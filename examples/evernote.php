<?php require_once __DIR__ . '/../vendor/autoload.php';

/*
 * Copyright (c) 2014, Yahoo! Inc. All rights reserved.
 * Copyrights licensed under the New BSD License.
 * See the accompanying LICENSE file for terms.
 */

use ohmy\Auth1;

# do 3-legged oauth
$tumblr = Auth1::legs(3)
    # configuration
    ->set(array(
        'consumer_key'    => 'key',
        'consumer_secret' => 'secret',
        'callback'        => 'your-callback-url'
    ))
    # oauth flow
    ->request('https://www.evernote.com/oauth')
    ->authorize('https://www.evernote.com/OAuth.action')
    ->access('https://www.evernote.com/OAuth.action')
    ->finally(function($data) use(&$token, &$secret) {
        echo '<pre>';
        var_dump($data);
        echo '</pre>';
    });

;

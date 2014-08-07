<?php require_once __DIR__ . '/../vendor/autoload.php';

/*
 * Copyright (c) 2014, Yahoo! Inc. All rights reserved.
 * Copyrights licensed under the New BSD License.
 * See the accompanying LICENSE file for terms.
 */

use ohmy\Auth1;

# initialize 3-legged oauth
$evernote = Auth1::legs(3)
       # configuration
       ->set('key', 'your consumer key')
       ->set('secret', 'your consumer secret')
       ->set('callback', 'your callback url')
       ->request('https://www.evernote.com/oauth')
       ->authorize('https://www.evernote.com/OAuth.action')
       ->access('https://www.evernote.com/oauth')
       ->finally(function($data) {
          var_dump($data);
       });


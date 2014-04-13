<?php require_once __DIR__ . '/../vendor/autoload.php';

/*
 * Copyright (c) 2014, Yahoo! Inc. All rights reserved.
 * Copyrights licensed under the New BSD License.
 * See the accompanying LICENSE file for terms.
 */

use ohmy\Auth1;

# initialize 3-legged oauth
$twitter = Auth1::legs(3)

                # configuration
                ->set(array(
                    'key'      => 'your consumer key',
                    'secret'   => 'your consumer secret',
                    'callback' => 'your callback url'
                ))

                # oauth flow
                ->request('https://api.twitter.com/oauth/request_token')
                ->authorize('https://api.twitter.com/oauth/authorize')
                ->access('https://api.twitter.com/oauth/access_token');

# test GET call
$twitter->GET('https://api.twitter.com/1.1/statuses/home_timeline.json', array('count' => 5))
        ->then(function($response) {
            echo '<pre>';
            var_dump($response->json());
            echo '</pre>';
        });


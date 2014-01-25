<?php namespace ohmy\Auth1\Promise;

/*
 * Copyright (c) 2014, Yahoo! Inc. All rights reserved.
 * Copyrights licensed under the New BSD License.
 * See the accompanying LICENSE file for terms.
 */

use http\Client,
    ohmy\Auth1\Promise,
    ohmy\Auth1\SignedRequest;

class Request {

    public static function request($url, $oauth) {
        $client = new Client;
        return new Promise(function($resolve, $reject) use($url, $oauth, $client) {
            $request = new SignedRequest(
                'POST',
                $url,
                $oauth
            );

            $client->enqueue($request, function($response) use($resolve, $reject) {
                echo '<pre>';
                var_dump($response->getResponseCode());
                echo '</pre>';
                if ($response->getResponseCode() === 200) {
                    $resolve($response->getBody()->toString());
                }
            });
            $client->send();
        });
    }
}

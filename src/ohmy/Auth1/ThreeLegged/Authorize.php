<?php namespace ohmy\Auth1\ThreeLegged;

/*
 * Copyright (c) 2014, Yahoo! Inc. All rights reserved.
 * Copyrights licensed under the New BSD License.
 * See the accompanying LICENSE file for terms.
 */

use ohmy\Auth\Promise,
    ohmy\Auth1\TwoLegged\Access,
    ohmy\Auth1\Security\SignedRequest,
    http\Client;

class Authorize extends Promise {

    public function __construct($callback, $client=null) {
        parent::__construct($callback);
        $this->client = ($client) ?  $client : new Client;
    }

    public function access($url, $options) {
        $promise = $this;
        return (new Access(function($resolve, $reject) use($promise, $url, $options) {

            // sign request
            $request = new SignedRequest(
                ($options['method']) ? $options['method'] : 'POST',
                $url,
                array_intersect_key(
                    $promise->value,
                    array_flip(array(
                        'oauth_callback',
                        'oauth_consumer_key',
                        'oauth_consumer_secret',
                        'oauth_nonce',
                        'oauth_signature_method',
                        'oauth_timestamp',
                        'oauth_token',
                        'oauth_token_secret',
                        'oauth_version'
                    ))
                )
            );

            $promise->client->enqueue($request, function($response) use($promise, $resolve, $reject) {
                echo '<pre>';
                var_dump($response->getBody()->toString());
                echo '</pre>';
                if ($response->getResponseCode() === 200) {
                    $resolve($response->getBody()->toString());
                }
            });

            $promise->client->send();

        }, $this->client))

        ->then(function($data) use($promise) {
            parse_str($data, $array);
            return array_merge($promise->value, $array);
        });
    }
}

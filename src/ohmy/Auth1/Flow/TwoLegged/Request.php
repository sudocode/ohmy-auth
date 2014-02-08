<?php namespace ohmy\Auth1\Flow\TwoLegged;

/*
 * Copyright (c) 2014, Yahoo! Inc. All rights reserved.
 * Copyrights licensed under the New BSD License.
 * See the accompanying LICENSE file for terms.
 */

use ohmy\Auth\Promise,
    ohmy\Auth1\Security\Signature,
    ohmy\Http\Rest;

class Request extends Promise {

    public function __construct($callback, Rest $client=null) {
        parent::__construct($callback);
        $this->client = $client;
    }

    public function access($url, $options=null) {
        $access = new Access(function($resolve, $reject) use($url, $options) {

            # sign request
            $signature = new Signature(
                ($options['method']) ? $options['method'] : 'POST',
                $url,
                array_intersect_key(
                    $this->value,
                    array_flip(array(
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

            $this->client->POST($url, array(), array(
                'Authorization'  => $signature,
                'Content-Length' => 0
            ))
            ->then(function($response) use($resolve) {
                $resolve($response->text());
            });


        }, $this->client);

        return $access->then(function($data) {
            parse_str($data, $array);
            return array_merge($this->value, $array);
        });
    }
}

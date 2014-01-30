<?php namespace ohmy\Auth1\Flow\TwoLegged;

/*
 * Copyright (c) 2014, Yahoo! Inc. All rights reserved.
 * Copyrights licensed under the New BSD License.
 * See the accompanying LICENSE file for terms.
 */

use ohmy\Auth\Promise,
    ohmy\Auth\Response,
    ohmy\Auth1\Security\Signature;

class Access extends Promise {

    public function __construct($callback, $client=null) {
        parent::__construct($callback);
        $this->client = $client;
    }

    public function GET($url, $params=null) {
        return $this->request('GET', $url, $params);
    }

    public function POST($url, $params=null) {
        return $this->request('POST', $url, $params);
    }

    private function request($method, $url, $options=null) {
        $promise = $this;
        return new Response(function($resolve, $reject) use($promise, $method, $url, $options) {

            # sign request
            $signature = new Signature(
                $method,
                $url,
                array_intersect_key(
                    $promise->value,
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

            $promise->client->{$method}($url, null, array(
                'Authorization'  => $signature,
                'Content-Length' => 0
            ))
            ->then(function($response) use($resolve) {
                $resolve($response->text());
            });

        });
    }
}

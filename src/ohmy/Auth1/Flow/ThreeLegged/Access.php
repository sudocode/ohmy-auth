<?php namespace ohmy\Auth1\ThreeLegged;

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
        $this->client = ($client) ?  $client : new Client;
    }

    public function GET($url, $options) {
        return $this->request('GET', $url, $options);
    }

    public function POST($url, $options) {
        return $this->request('POST', $url, $options);
    }

    private function request($method, $url, $options) {
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

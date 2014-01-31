<?php namespace ohmy\Auth1\Flow\ThreeLegged;

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

    public function GET($url, Array $params=null, Array $headers=array()) {
        return $this->request('GET', $url, $params, $headers);
    }

    public function POST($url, Array $params=null, Array $headers=array()) {
        return $this->request('POST', $url, $params, $headers);
    }

    private function request($method, $url, Array $params=null, Array $headers=array()) {
        echo 'access';
        $promise = $this;
        return new Response(function($resolve, $reject) use($promise, $method, $url, $params, $headers) {

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
                ),
                $params,
                $headers
            );

            # set Authorization header
            $headers['Authorization'] = $signature;

            $promise->client->{$method}($url, $params, $headers)
                    ->then(function($response) use($resolve) {
                        $resolve($response->text());
                    });

        });
    }
}

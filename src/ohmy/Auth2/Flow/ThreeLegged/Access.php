<?php namespace ohmy\Auth2\Flow\ThreeLegged;

/*
 * Copyright (c) 2014, Yahoo! Inc. All rights reserved.
 * Copyrights licensed under the New BSD License.
 * See the accompanying LICENSE file for terms.
 */

use ohmy\Auth\Promise,
    ohmy\Auth\Response;

class Access extends Promise {

    public function __construct($callback, $client=null) {
        parent::__construct($callback);
        $this->client = $client;
    }

    public function GET($url, $params=array(), $headers=array()) {
        $url = parse_url($url);
        if (isset($url['query'])) parse_str($url['query'], $params);
        return $this->request(
            'GET', 
            $url['scheme'].'://'.$url['host'].$url['path'],
            $params,
            $headers
        );
    }

    public function POST($url, $params=array(), $headers=array()) {
        $url = parse_url($url);
        if (isset($url['query'])) parse_str($url['query'], $params);
        return $this->request(
            'GET', 
            $url['scheme'].'://'.$url['host'].$url['path'],
            $params,
            $headers
        );
    }

    private function request($method, $url, $params=null, $headers=null) {
        $promise = $this;
        return new Response(function($resolve, $reject) use($promise, $method, $url, $params, $headers) {
            $params['access_token'] = $promise->value['access_token'];
            $promise->client->{$method}($url, $params, $headers)
                    ->then(function($response) use($resolve) {
                        $resolve($response->text());
                    });
        });
    }
}

<?php namespace ohmy\Auth2\Flow\ThreeLegged;

/*
 * Copyright (c) 2014, Yahoo! Inc. All rights reserved.
 * Copyrights licensed under the New BSD License.
 * See the accompanying LICENSE file for terms.
 */

use ohmy\Auth\Promise;

class Authorize extends Promise {

    public function __construct($callback, $client=null) {
        parent::__construct($callback);
        $this->client = $client;
    }

    public function access($url, $options) {
        $promise = $this;
        return (new Access(function($resolve, $reject) use($promise, $url, $options) {
            $promise->client->POST($url, array(
                'client_id'     => $promise->value['client_id'],
                'client_secret' => $promise->value['client_secret'],
                'code'          => $promise->value['code'],
                'redirect_uri'  => $promise->value['redirect_uri']
            ))
            ->then(function($response) use($resolve) {
                $resolve($response->text());
            });

        }, $this->client))
        ->then(function($data) use($promise) {
            parse_str($data, $array);
            return array_merge($promise->value, $array);
        });
    }
}

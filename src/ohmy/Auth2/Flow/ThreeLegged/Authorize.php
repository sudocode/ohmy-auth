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

    public function access($url, Array $options=array()) {
        return (new Access(function($resolve, $reject) use($url, $options) {
            $this->client->POST($url, array(
                'client_id'     => $this->value['client_id'],
                'client_secret' => $this->value['client_secret'],
                'code'          => $this->value['code'],
                'redirect_uri'  => $this->value['redirect_uri']
            ))
            ->then(function($response) use($resolve) {
                $resolve($response->text());
            });

        }, $this->client))
        ->then(function($data) {
            parse_str($data, $array);
            return array_merge($this->value, $array);
        });
    }
}

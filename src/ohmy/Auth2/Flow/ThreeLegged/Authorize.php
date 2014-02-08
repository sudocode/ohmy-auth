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
        $access = new Access(function($resolve, $reject) use($url, $options) {
            $this->client->POST($url, array(
                'grant_type'    => 'authorization_code',
                'client_id'     => $this->value['client_id'],
                'client_secret' => $this->value['client_secret'],
                'code'          => $this->value['code'],
                'redirect_uri'  => $this->value['redirect_uri']
            ))
            ->then(function($response) use($resolve) {
                $resolve($response->text());
            });

        }, $this->client);

        return $access->then(function($data) {
            $value = null;
            parse_str($data, $array);
            if (count($array) === 1) {
                $json = json_decode($data, true);
                if ($json) $value = array_merge($this->value, $json);
                else $value['response'] = $data;
            }
            else $value =  array_merge($this->value, $array);
            return $value;
        });
    }
}

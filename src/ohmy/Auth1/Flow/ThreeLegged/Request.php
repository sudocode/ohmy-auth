<?php namespace ohmy\Auth1\Flow\ThreeLegged;

/*
 * Copyright (c) 2014, Yahoo! Inc. All rights reserved.
 * Copyrights licensed under the New BSD License.
 * See the accompanying LICENSE file for terms.
 */

use ohmy\Auth\Promise,
    ohmy\Http\Rest;

class Request extends Promise {

    public function __construct($callback, Rest $client=null) {
        parent::__construct($callback);
        $this->client = $client;
    }

    public function authorize($url, $options=array()) {
        return (new Authorize(function($resolve, $reject) use($url, $options) {

            # check session
            if ($this->value['oauth_token'] && $this->value['oauth_verifier']) {
                $resolve($this->value);
                return;
            }

            $location = sprintf(
                'Location: %s?oauth_token=%s',
                $url,
                $this->value['oauth_token']
            );

            header($location);
            exit();
        }, $this->client));

    }
}

<?php namespace ohmy\Auth1\Flow\ThreeLegged;

/*
 * Copyright (c) 2014, Yahoo! Inc. All rights reserved.
 * Copyrights licensed under the New BSD License.
 * See the accompanying LICENSE file for terms.
 */

use ohmy\Auth\Promise;

class Request extends Promise {

    public function __construct($callback, $client=null) {
        parent::__construct($callback);
        $this->client = $client;
    }

    public function authorize($url, $options) {
        $promise = $this;
        return (new Authorize(function($resolve, $reject) use($promise, $url, $options) {

            error_log('DATA IS '.json_encode($promise->value));

            # check session
            if ($promise->value['oauth_token'] && $promise->value['oauth_verifier']) {
                $resolve($promise->value);
                return;
            }

            $location = sprintf(
                'Location: %s?oauth_token=%s',
                $url,
                $promise->value['oauth_token']
            );
            error_log("LOCATION IS $location");

            header($location);
            exit();
        }, $this->client));

    }
}

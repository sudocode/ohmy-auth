<?php namespace ohmy\Auth2\Flow;

/*
 * Copyright (c) 2014, Yahoo! Inc. All rights reserved.
 * Copyrights licensed under the New BSD License.
 * See the accompanying LICENSE file for terms.
 */

use ohmy\Auth\Promise,
    ohmy\Auth2\Flow\ThreeLegged\Authorize,
    http\Client;

class ThreeLegged extends Promise {

    private $client;

    public function __construct($callback, $client=null) {
        parent::__construct($callback);
        $this->client = ($client) ?  $client : new Client;
    }

    public function authorize($url, $options) {
        $promise = $this;
        return new Authorize(function($resolve, $reject) use($promise, $url, $options) {




            $location = sprintf(
                'Location: %s?oauth_token=%s',
                $url,
                $promise->value['oauth_token']
            );

            header($location);
            exit();

        }, $this->client);
    }
}
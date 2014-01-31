<?php namespace ohmy\Auth2\Flow;

/*
 * Copyright (c) 2014, Yahoo! Inc. All rights reserved.
 * Copyrights licensed under the New BSD License.
 * See the accompanying LICENSE file for terms.
 */

use ohmy\Auth2\Flow,
    ohmy\Auth2\Flow\ThreeLegged\Authorize;

class ThreeLegged extends Flow {

    private $client;

    public function __construct($callback, $client=null) {
        parent::__construct($callback);
        $this->client = $client;
    }

    public function authorize($url, Array $options=array()) {
        $promise = $this;
        return new Authorize(function($resolve, $reject) use($promise, $url, $options) {

            if($promise->value['code']) {
                $resolve($promise->value);
                return;
            }

            $location = $url.'?'.http_build_query(array(
                'client_id'     => $promise->value['client_id'],
                'redirect_uri'  => $promise->value['redirect_uri'],
                'response_type' => $promise->value['response_type'],
                'scope'         => $promise->value['scope']

            ));

            header("Location: $location");
            exit();

        }, $this->client);
    }
}

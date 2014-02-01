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
        return new Authorize(function($resolve, $reject) use($url, $options) {

            if($this->value['code']) {
                $resolve($this->value);
                return;
            }

            $location = $url.'?'.http_build_query(array(
                'response_type' => 'code',
                'client_id'     => $this->value['client_id'],
                'redirect_uri'  => $this->value['redirect_uri'],
                'scope'         => $this->value['scope'],
                'state'         => $this->value['state']

            ));

            header("Location: $location");
            exit();

        }, $this->client);
    }
}

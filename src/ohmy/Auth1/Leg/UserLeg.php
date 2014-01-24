<?php namespace ohmy\Auth1\Leg;

/*
 * Copyright (c) 2014, Yahoo! Inc. All rights reserved.
 * Copyrights licensed under the New BSD License.
 * See the accompanying LICENSE file for terms.
 */

use ohmy\Auth1\Leg;

class UserLeg extends Leg {

    public function __construct(
        $url,
        Array $oauth_params=array(),
        Array $params=array(),
        Array $headers=array(),
        $callback=null
    ) {
        $this->url = $url;
        $this->oauth_params = $oauth_params;
        $this->params = $params;
        $this->headers = $headers;
    }

    public function run() {
        $location = sprintf(
            'Location: %s?oauth_token=%s',
            $this->url,
            $this->oauth_params['oauth_token']
        );
        header($location);
        exit();
    }
}

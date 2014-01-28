<?php namespace ohmy\Auth1\Security;

/*
 * Copyright (c) 2014, Yahoo! Inc. All rights reserved.
 * Copyrights licensed under the New BSD License.
 * See the accompanying LICENSE file for terms.
 */

use http\Client\Request;

class SignedRequest extends Request {

    private $signature;
    private $params;

    public function __construct($method, $url, $oauth_params=array(), $params=array(), $headers=array(), $sig_location='header') {

        parent::__construct($method, $url, $headers);

        $url= parse_url($url);
        $params = array_merge($oauth_params, $params);
        parse_str($url['query'], $_params);
        $params = array_merge($params, $_params);
        $oauth_consumer_secret = $params['oauth_consumer_secret'];
        $oauth_token_secret = (isset($params['oauth_token_secret'])) ? $params['oauth_token_secret'] : '';

        unset($params['oauth_consumer_secret']);
        unset($params['oauth_token_secret']);

        ksort($params);

        $this->signature = new Signature(
            $method,
            $url['scheme'].'://'.$url['host'].$url['path'],
            $params,
            $oauth_consumer_secret,
            $oauth_token_secret
        );

        $this->params = $params;
        $this->signHeader();
    }

    public function signQueryString() {
        # add as query string
    }

    public function signHeader() {
        # add as header
        $output = array();

        foreach($this->params as $key => $value) {
            array_push($output, "$key=\"". $value ."\"");
        }

        array_push(
            $output,
            'oauth_signature="'. rawurlencode($this->signature) .'"'
        );
        # sort($output);
        $output = 'OAuth '.implode(', ', $output);
        $this->addHeader('Authorization', $output);
        $this->addHeader('Content-Length', 0);
        return $output;
    }

    public function signPostFields() {
        # add as postfield
    }

    public function sign() {
    }

}

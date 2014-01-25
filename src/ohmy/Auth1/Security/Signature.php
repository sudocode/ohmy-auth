<?php namespace ohmy\Auth1\Security;

/*
 * Copyright (c) 2014, Yahoo! Inc. All rights reserved.
 * Copyrights licensed under the New BSD License.
 * See the accompanying LICENSE file for terms.
 */

class Signature {

    private $method;
    private $url;
    private $params;
    private $type;
    private $oauth_consumer_secret;
    private $oauth_token_secret;
    private $debug = false;

    public function __construct(
        $method,
        $url,
        $params,
        $oauth_consumer_secret = '',
        $oauth_token_secret = '',
        $type='HMAC-SHA1'
    ) {

        $this->method = $method;
        $this->url = $url;
        $this->params = $params;
        $this->oauth_consumer_secret = $oauth_consumer_secret;
        $this->oauth_token_secret = $oauth_token_secret;
        $this->type = $type;

    }

    public function __toString() {
        $base_string = $this->getBaseString();
        $signing_key = $this->getSigningKey();
        $oauth_signature = null;

        switch($this->type) {
            case 'PLAINTEXT':
                break;
            case 'HMAC-SHA1':
                $oauth_signature = base64_encode(hash_hmac(
                    'sha1',
                    $base_string,
                    $signing_key,
                    true
                ));
                break;
            case 'RSA-SHA1':
                break;
            default:
        }

        if ($this->debug) error_log("OAUTH_SIGNATURE: $oauth_signature");
        return $oauth_signature;
    }

    private function getQueryString() {
        $output = array();
        foreach($this->params as $key => $value) {
            array_push($output, "$key=$value");
        }
        return implode('&', $output);
    }

    private function getBaseString() {

        $output =  $this->method
                   .'&'
                   .rawurlencode($this->url)
                   .'&'
                   .rawurlencode($this->getQueryString());

        if ($this->debug) error_log("SIGNATURE BASE STRING: $output");
        return $output;
    }

    private function getSigningKey() {
        $output =  $this->oauth_consumer_secret
                   .'&'
                   .$this->oauth_token_secret;

        if ($this->debug) error_log("SIGNING KEY: $output");
        return $output;
    }

}

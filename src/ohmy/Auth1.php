<?php namespace ohmy;

/*
 * Copyright (c) 2014, Yahoo! Inc. All rights reserved.
 * Copyrights licensed under the New BSD License.
 * See the accompanying LICENSE file for terms.
 */

use ohmy\Auth1\Flow\TwoLegged,
    ohmy\Auth1\Flow\ThreeLegged,
    ohmy\Http\Curl;

class Auth1 {

    public static function init($type, $params=array()) {

        $client = new Curl;
        $oauth = array(
            'oauth_callback'           => '',
            'oauth_callback_confirmed' => $_SESSION['oauth_callback_confirmed'],
            'oauth_consumer_key'       => '',
            'oauth_consumer_secret'    => '',
            'oauth_nonce'              => md5(mt_rand()),
            'oauth_signature_method'   => 'HMAC-SHA1',
            'oauth_timestamp'          => time(),
            'oauth_token'              => $_REQUEST['oauth_token'],
            'oauth_token_secret'       => $_SESSION['oauth_token_secret'],
            'oauth_verifier'           => $_REQUEST['oauth_verifier'],
            'oauth_version'            => '1.0'
        );

        # encode all params
        foreach($oauth as $key => $val) $oauth[$key] = rawurlencode($val);

        switch($type) {
            case 2:
                return new TwoLegged(function($resolve) use($oauth) {
                    $resolve($oauth);
                }, $client);
                break;
            case 3:
                return new ThreeLegged(function($resolve) use($oauth) {
                    $resolve($oauth);
                }, $client);
                break;
            default:
        }
    }
}

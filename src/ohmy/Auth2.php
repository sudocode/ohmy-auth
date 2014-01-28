<?php namespace ohmy;

/*
 * Copyright (c) 2014, Yahoo! Inc. All rights reserved.
 * Copyrights licensed under the New BSD License.
 * See the accompanying LICENSE file for terms.
 */

use ohmy\Auth2\Model,
    ohmy\Auth2\Flow\TwoLegged,
    ohmy\Auth2\Flow\ThreeLegged;

class Auth2 {

    public static function init($type, $params=array()) {
        $model = new Model(array(
            'oauth_consumer_key'       => $params['consumer_key'],
            'oauth_consumer_secret'    => $params['consumer_secret'],
            'oauth_token'              => $_REQUEST['oauth_token'],
            'oauth_token_secret'       => $_SESSION['oauth_token_secret'],
            'oauth_verifier'           => $_REQUEST['oauth_verifier'],
            'oauth_callback'           => ($params['callback']) ? $params['callback'] : '',
            'oauth_callback_confirmed' => $_SESSION['oauth_callback_confirmed']
        ));

        switch($type) {
            case 2:
                return new TwoLegged($model, function($resolve) {
                    $resolve(true);
                });
                break;
            case 3:
                return new ThreeLegged($model, function($resolve) {
                    $resolve(true);
                });
                break;
            default:
        }
    }

}

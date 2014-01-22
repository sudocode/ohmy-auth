/*
 * Copyright (c) 2014, Yahoo! Inc. All rights reserved.
 * Copyrights licensed under the New BSD License.
 * See the accompanying LICENSE file for terms.
 */
<?php namespace ohmy;

    use ohmy\Auth1\Model,
        ohmy\Auth1\Flow\Factory;

    class Auth {

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
            return Factory::construct($type, $params, $model);
        }

    }

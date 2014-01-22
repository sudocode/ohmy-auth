/*
 * Copyright (c) 2014, Yahoo! Inc. All rights reserved.
 * Copyrights licensed under the New BSD License.
 * See the accompanying LICENSE file for terms.
 */
<?php namespace ohmy\Auth1\Flow;

    use ohmy\Auth1\Flow,
        ohmy\Auth1\Model;

    class TwoLegged extends Flow {

        public function __construct(
            Model $model,
            $request_token_url,
            $access_token_url
        ) {
            parent::__construct(
                $model,
                array(
                    # first leg
                    array(
                        'type'     => 'machine',
                        'url'      => $request_token_url,
                        'have'     => array(
                            'oauth_consumer_key',
                            'oauth_consumer_secret',
                            'oauth_timestamp',
                            'oauth_nonce',
                            'oauth_signature_method',
                            'oauth_version'
                        ),
                        'want'     => array(
                            'oauth_token',
                            'oauth_token_secret'
                        ),
                        'params'   => array(),
                        'headers'  => array(),
                        'callback' => function($data) use($model) {
                            $model->setArray($data);
                        }
                    ),
                    # second leg
                    array(
                        'type'     => 'machine',
                        'url'      => $request_token_url,
                        'have'     => array(
                            'oauth_consumer_key',
                            'oauth_consumer_secret',
                            'oauth_token',
                            'oauth_token_secret',
                            'oauth_timestamp',
                            'oauth_nonce',
                            'oauth_signature_method',
                            'oauth_version',
                            'oauth_callback'
                        ),
                        'want'     => array(
                            'nop'
                        ),
                        'params'   => array(),
                        'headers'  => array(),
                        'callback' => function() {}
                    )
                )
            );
        }
    }

?>

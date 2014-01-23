<?php namespace ohmy\Auth1\Flow;

/*
 * Copyright (c) 2014, Yahoo! Inc. All rights reserved.
 * Copyrights licensed under the New BSD License.
 * See the accompanying LICENSE file for terms.
 */

use ohmy\Auth1\Flow,
    ohmy\Auth1\Model;

class OneLegged extends Flow {

    public function __construct(
        Model $model,
        $resource_url
    ) {
        parent::__construct(
            $model,
            array(
                # first leg
                array(
                    'type'     => 'machine',
                    'url'      => $resource_url,
                    'have'     => array(
                        'oauth_token',
                        'oauth_consumer_key',
                        'oauth_consumer_secret',
                        'oauth_timestamp',
                        'oauth_nonce',
                        'oauth_signature_method',
                        'oauth_version'
                    ),
                    'want'     => array('nop'),
                    'params'   => array(),
                    'headers'  => array(),
                    'callback' => function($data) {
                        var_dump($data);
                    }
                )
            )
        );
    }
}

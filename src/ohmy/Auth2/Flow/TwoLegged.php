<?php namespace ohmy\Auth2\Flow;

/*
 * Copyright (c) 2014, Yahoo! Inc. All rights reserved.
 * Copyrights licensed under the New BSD License.
 * See the accompanying LICENSE file for terms.
 */

use ohmy\Auth2\Flow;

class TwoLegged extends Flow {

    private $client;
    private $model;

    public function __construct($model, $callback, $client=null) {
        parent::__construct($callback);
        $this->client = $client;
    }

    public function authorize($url) {
        return new TwoLegged($this->model, function($resolve, $reject) use($url) {
            header("Location: $url");
            exit();
        });
    }

    public function access($token) {

    }
}
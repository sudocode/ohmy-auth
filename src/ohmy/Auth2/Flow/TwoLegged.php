<?php namespace ohmy\Auth2\Flow;

/*
 * Copyright (c) 2014, Yahoo! Inc. All rights reserved.
 * Copyrights licensed under the New BSD License.
 * See the accompanying LICENSE file for terms.
 */

use ohmy\Auth\Promise;

class TwoLegged extends Promise {

    private $client;
    private $model;

    public function __construct($model, $callback, $client=null) {
        parent::__construct($callback);
        $this->client = ($client) ?  $client : new Client;
    }

    public function authorize($url) {
        $promise = $this;
        return new TwoLegged($this->model, function($resolve, $reject) use($promise, $url) {
            header("Location: $url");
            exit();
        });
    }

    public function access() {
        return new TwoLegged(function($resolve, $reject) {
        });
    }
} 
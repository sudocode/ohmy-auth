<?php namespace ohmy\Components\Session;

/*
 * Copyright (c) 2014, Yahoo! Inc. All rights reserved.
 * Copyrights licensed under the New BSD License.
 * See the accompanying LICENSE file for terms.
 */

use ohmy\Components\Session;

class PHPSession implements Session {

    public function __construct() {
        session_start();
    }

    public function create($key, $value) {
        $_SESSION[$key] = $value;
    }

    public function read($key) {
        return $_SESSION[$key];
    }

    public function update($key, $value) {
        $_SESSION[$key] = $value;
    }

    public function delete($key) {
        unset($_SESSION[$key]);
    }

    public function __destruct() {
        session_destroy();
    }
}
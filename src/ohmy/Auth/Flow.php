<?php namespace ohmy\Auth;

/*
 * Copyright (c) 2014, Yahoo! Inc. All rights reserved.
 * Copyrights licensed under the New BSD License.
 * See the accompanying LICENSE file for terms.
 */

class Flow extends Promise {
    public function set($key, $value) {
        $this->value[$key] = $value;
        return $this;
    }
}
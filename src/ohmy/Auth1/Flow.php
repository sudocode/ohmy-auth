<?php namespace ohmy\Auth1;

/*
 * Copyright (c) 2014, Yahoo! Inc. All rights reserved.
 * Copyrights licensed under the New BSD License.
 * See the accompanying LICENSE file for terms.
 */

use ohmy\Auth\Promise;

abstract class Flow extends Promise {
    public function set($key, $value) {
        switch($key) {
            case 'oauth_consumer_key':
            case 'consumer_key':
            case 'key':
                $this->value['oauth_consumer_key'] = $value;
                break;
            case 'oauth_consumer_secret':
            case 'consumer_secret':
            case 'secret':
                $this->value['oauth_consumer_secret'] = $value;
                break;
            case 'oauth_callback':
            case 'callback':
                $this->value['oauth_callback'] = $value;
                break;
            default:
                $this->value[$key] = $value;
        }
        return $this;
    }

    public abstract function access($token, $secret);
}

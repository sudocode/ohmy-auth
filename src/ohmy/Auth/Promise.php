<?php namespace ohmy\Auth;

/*
 * Copyright (c) 2014, Yahoo! Inc. All rights reserved.
 * Copyrights licensed under the New BSD License.
 * See the accompanying LICENSE file for terms.
 */

class Promise {

    const PENDING = 0;
    const RESOLVED = 1;
    const REJECTED = 2;

    protected $state = self::PENDING;
    protected $success_pending = array();
    protected $failure_pending = array();
    protected $value = null;

    function __construct($callback) {
        $promise = $this;
        $callback(function($value) use($promise) {
            $promise->_resolve($value);
        },
        function($value) use($promise) {
            $promise->_reject($value);
        });
    }

    /**
     * Dispatch queued callbacks.
     * Also sets state to RESOLVED.
     * @param $value
     */
    private function _resolve($value) {
        if ($this->state === self::PENDING) {
            $this->value = $value;
            for ($i = 0; $i < count($this->success_pending); $i++) {
                $callback = $this->success_pending[$i];
                $callback($value);
            }
            $this->state = self::RESOLVED;
        }
    }

    /**
     * Returns a promise that always resolves.
     * @param $value
     * @return Promise
     */
    public static function resolve($value) {
        return new Promise(function($resolve) use($value) {
            $resolve($value);
        });
    }

    /**
     * Returns a promise that always rejects.
     * @param $value
     * @return Promise
     */
    public static function reject($value) {
        return new Promise(function($resolve, $reject) use($value) {
            $reject($value);
        });
    }

    /**
     * Dispatch queued callbacks.
     * Also sets state to REJECTED.
     * @param $value
     */
    private function _reject($value) {
        if ($this->state === self::PENDING) {
            $this->value = $value;
            for ($i = 0; $i < count($this->failure_pending); $i++) {
                $callback = $this->failure_pending[$i];
                $callback($value);
            }
            $this->state = self::REJECTED;
        }
    }

    /**
     * Execute success/failure callbacks after the promise's fate
     * has been determined.
     * @param $success
     * @param null $failure
     * @return $this
     */
    public function then($success, $failure=null) {
        if ($this->state === self::PENDING) {
            if ($success) array_push($this->success_pending, $success);
            if ($failure) array_push($this->failure_pending, $failure);
        }
        else if ($this->state === self::RESOLVED) {
            $this->value = $success($this->value);
        }
        else if ($this->state === self::REJECTED) {
            if ($failure) $this->value = $failure($this->value);
        }
        return $this;
    }

    public function __call($function, $arguments) {
        if ($function === 'catch') {
            call_user_func(array($this, '_catch'), $arguments[0]);
        }
    }

    /**
     * Execute a callback if the promise has been rejected.
     * @param $callback
     * @return $this
     */
    private function _catch($callback) {
        if ($this->state === self::REJECTED) {
            $callback($this->value);
        }
        return $this;
    }
}



/*
 * Copyright (c) 2014, Yahoo! Inc. All rights reserved.
 * Copyrights licensed under the New BSD License.
 * See the accompanying LICENSE file for terms.
 */
<?php namespace ohmy\Auth1;

    abstract class Leg {

        protected $url;
        protected $callback;

        public abstract function run();

        public function setUrl($url) {
            $this->url = $url;
        }

        public function setCallback($callback) {
            $this->callback = $callback;
        }
    }

?>

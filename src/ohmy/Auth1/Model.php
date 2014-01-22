/*
 * Copyright (c) 2014, Yahoo! Inc. All rights reserved.
 * Copyrights licensed under the New BSD License.
 * See the accompanying LICENSE file for terms.
 */
<?php namespace ohmy\Auth1;

    class Model {

        public $debug = true;

        private $params = array(

            # consumer key
            # consumer secret
            # callback 
             
            'oauth_nonce'            => '',
            'oauth_timestamp'        => '',
            'oauth_signature_method' => '',
            'oauth_version'          => '',
            'oauth_token_secret'     => ''
        );

        private function init() {
            $this->set('oauth_nonce', md5(mt_rand()));
            $this->set('oauth_timestamp', time());
            $this->set('oauth_signature_method', 'HMAC-SHA1');
            $this->set('oauth_version', '1.0');
        }

        function __construct($options) {
            $this->init();
            $this->setArray($options);
        }

        public function set($key, $value=null, $encode=true) {
            if (is_array($key)) {
                $this->setArray($key, $encode);
            }
            else $this->setKeyValue($key, $value, $encode);
        }

        public function setArray($array, $encode=true) {
            foreach($array as $key => $value) {
                $this->setKeyValue($key, $value, $encode);
            }
        }

        private function setKeyValue($key, $value, $encode) {
            $this->params[$key] = ($encode) ? rawurlencode($value) : $value;
            ksort($this->params);
        }

        public function has($params=array()) {
            if (empty($params)) return true;
            else {
                foreach ($params as $p) {
                    $value = $this->get($p);
                    if (!empty($value)) continue;
                    else {
                        return false;
                    }
                }
                return true;
            }
        }

        public function get($key, $decode=false) {
            return ($decode) ? rawurldecode($this->params[$key]) : $this->params[$key];
        }

        public function getArray($array) {
            $output = array();
            foreach($array as $key) {
                $output[$key] = $this->get($key);
            }
            ksort($output);
            return $output;
        }
    }

?>

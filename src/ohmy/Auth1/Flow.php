/*
 * Copyright (c) 2014, Yahoo! Inc. All rights reserved.
 * Copyrights licensed under the New BSD License.
 * See the accompanying LICENSE file for terms.
 */
<?php namespace ohmy\Auth1;

    use ohmy\Auth1\Leg\MachineLeg,
        ohmy\Auth1\Leg\UserLeg;

    class Flow {

        protected $model;
        protected $queue;
        protected $index = 0;

        public function __construct($model, $queue=array()) {
            $this->model = $model;
            $this->queue = $queue;
        }

        public function leg($url=null, $callback=null) {
            $leg = $this->queue[$this->index];


            # check if pre condition has been met
            # check if conditions have already been met
            if ($this->model->has($leg['want'])) {
                $this->index++;
                return $this;
            }

            # if condition has not been met and url is null
            if ($url == null) {
                return $this;
            }

            switch($leg['type']) {
                case 'machine':
                    $leg = new MachineLeg(
                        $leg['url'],
                        $this->model->getArray($leg['have']),
                        $leg['params'],
                        $leg['headers'],
                        function($data) use($leg, $callback) {
                            $default_callback = $leg['callback'];
                            if (isset($default_callback)) $default_callback($data);
                            if (isset($callback)) $callback($data);
                        }
                    );
                    break;
                case 'user':
                    $leg = new UserLeg(
                        $leg['url'],
                        $this->model->getArray($leg['have']),
                        $leg['params'],
                        $leg['headers'],
                        $leg['callback']
                    );
                    break;
                default:
            }

            # overrides
            if (isset($url)) $leg->setUrl($url);

            $leg->run();
            $this->index++;
            return $this;
        }

        public function setConsumerKey($key) {
            $this->model->set('oauth_consumer_key', $key);
            return $this;
        }

        public function setConsumerSecret($secret) {
            $this->model->set('oauth_consumer_secret', $secret);
            return $this;
        }

        public function setOauthCallback($callback) {
            $this->model->set('oauth_callback', $callback);
            return $this;
        }

        public function set($key, $value) {
            switch($key) {
                case 'key':
                case 'consumer_key':
                case 'oauth_consumer_key':
                    $this->model->set('oauth_consumer_key', $value);
                    break;
                case 'secret':
                case 'consumer_secret':
                case 'oauth_consumer_secret':
                    $this->model->set('oauth_consumer_secret', $value);
                    break;
                case 'callback':
                case 'oauth_callback':
                    $this->model->set('oauth_callback', $value);
                    break;
                default:
            }

            return $this;
        }
    }

?>

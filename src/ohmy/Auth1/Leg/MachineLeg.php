/*
 * Copyright (c) 2014, Yahoo! Inc. All rights reserved.
 * Copyrights licensed under the New BSD License.
 * See the accompanying LICENSE file for terms.
 */
<?php namespace ohmy\Auth1\Leg;

    use http\Client,
        ohmy\Auth1\Leg,
        ohmy\Auth1\SignedRequest;

    /**
     * Class MachineLeg
     */
    class MachineLeg extends Leg {

            private $method = 'POST';
            private $client;

            private $oauth_params;
            private $params;
            private $headers;

        /**
         * @param string $url
         * @param array $oauth_params
         * @param array $params
         * @param array $headers
         * @param function $callback
         */
        public function __construct(
                $url,
                Array $oauth_params=array(),
                Array $params=array(),
                Array $headers=array(),
                $callback=null
            ) {
                $this->url = $url;
                $this->oauth_params = $oauth_params;
                $this->params = $params;
                $this->headers = $headers;
                $this->client = new Client;
                $this->callback = $callback;
            }

        /**
         * Parsing callback for SignRequest object
         *
         * @param $response
         */
        public function parse($response) {
                parse_str($response->getBody()->toString(), $array);
                if (isset($this->callback)) {
                    $callback = $this->callback;
                    $callback($array, $response);
                }
            }

        public function run() {

                $request = new SignedRequest(
                    $this->method,
                    $this->url,
                    $this->oauth_params
                );

                $this->client->enqueue($request, array($this, 'parse'));
                $this->client->send();
            }
        }

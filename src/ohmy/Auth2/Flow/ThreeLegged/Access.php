<?php namespace ohmy\Auth2\Flow\ThreeLegged;

use ohmy\Auth\Promise;

class Access extends Promise {

    public function __construct($callback, $client=null) {
        parent::__construct($callback);
        $this->client = ($client) ?  $client : new Client;
    }

    public function GET($url, $options=null) {
        $this->request('GET', $url, $options);
    }

    public function POST($url, $options=null) {
        $this->request('POST', $url, $options);
    }

    private function request($method, $url, $options=null) {
        $promise = $this;
        return new Response(function($resolve, $reject) use($promise, $method, $url, $options) {

            # sign request
            $request = new SignedRequest(
                $method,
                $url,
                array_intersect_key(
                    $promise->value,
                    array_flip(array(
                        'oauth_consumer_key',
                        'oauth_consumer_secret',
                        'oauth_nonce',
                        'oauth_signature_method',
                        'oauth_timestamp',
                        'oauth_token',
                        'oauth_token_secret',
                        'oauth_version'
                    ))
                )
            );

            $promise->client->enqueue($request, function($response) use($promise, $resolve, $reject) {
                if ($response->getResponseCode() === 200) {
                    $resolve($response->getBody()->toString());
                }
            });

            # send request
            $promise->client->send();

        });
    }
}
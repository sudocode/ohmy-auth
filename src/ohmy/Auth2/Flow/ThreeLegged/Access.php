<?php namespace ohmy\Auth2\Flow\ThreeLegged;

use ohmy\Auth\Promise,
    ohmy\Auth\Response;

class Access extends Promise {

    public function __construct($callback, $client=null) {
        parent::__construct($callback);
        $this->client = $client;
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
            $promise->client->{$method}($url, null, array(
            ))
            ->then(function($response) use($resolve) {
                $resolve($response->text());
            });
        });
    }
}
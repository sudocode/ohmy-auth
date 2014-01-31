<?php namespace ohmy\Auth2\Flow\ThreeLegged;

use ohmy\Auth\Promise,
    ohmy\Auth\Response;

class Access extends Promise {

    public function __construct($callback, $client=null) {
        parent::__construct($callback);
        $this->client = $client;
    }

    public function GET($url, $params=null, $headers=null) {
        $url = parse_url($url);
        parse_str($url['query'], $params);
        return $this->request(
            'GET', 
            $url['scheme'].'://'.$url['host'].$url['path'],
            $params,
            $headers
        );
    }

    public function POST($url, $params=null, $headers=null) {
        $url = parse_url($url);
        parse_str($url['query'], $params);
        return $this->request(
            'GET', 
            $url['scheme'].'://'.$url['host'].$url['path'],
            $params,
            $headers
        );
    }

    private function request($method, $url, $params=null, $headers=null) {
        $promise = $this;
        return new Response(function($resolve, $reject) use($promise, $method, $url, $params, $headers) {
            $params['access_token'] = $promise->value['access_token'];
            var_dump($params);
            $promise->client->{$method}($url, $params, $headers)
                    ->then(function($response) use($resolve) {
                        var_dump($response->text());
                        $resolve($response->text());
                    });
        });
    }
}

<?php namespace ohmy\Auth1\Flow;

use ohmy\Auth1\Promise,
    ohmy\Auth1\SignedRequest,
    http\Client;

class TwoLegged extends Promise {

    private $client;
    private $model;

    public function __construct($model, $callback, $client=null) {
        parent::__construct($callback);
        $this->model = $model;
        $this->client = ($client) ?  $client : new Client;
    }

    public function request($url, $success, $failure, $options) {
        $promise = $this;
        return (new TwoLegged($this->model, function($resolve, $reject) use($promise, $url, $options) {
            // sign request
            $request = new SignedRequest(
                ($options['method']) ? $options['method'] : 'POST',
                $url,
                $promise->model->getArray(array(
                    'oauth_consumer_key',
                    'oauth_consumer_secret',
                    'oauth_timestamp',
                    'oauth_nonce',
                    'oauth_signature_method',
                    'oauth_version'
                ))
            );

            $promise->client->enqueue($request, function($response) use($promise, $resolve, $reject) {
                if ($response->getResponseCode() === 200) {
                    $resolve($response->getBody()->toString());
                }
            });
            $promise->client->send();
        }, $this->client))->then(function($data) use($promise) {
            parse_str($data, $array);
            $promise->model->setArray($array);
        });
    }

    public function access($url, $success, $failure, $options) {
        $promise = $this;
        return (new TwoLegged($this->model, function($resolve, $reject) use($promise, $url, $options) {

            // sign request
            $request = new SignedRequest(
                ($options['method']) ? $options['method'] : 'POST',
                $url,
                $promise->model->getArray(array(
                    'oauth_consumer_key',
                    'oauth_consumer_secret',
                    'oauth_token',
                    'oauth_token_secret',
                    'oauth_timestamp',
                    'oauth_nonce',
                    'oauth_signature_method',
                    'oauth_version',
                    'oauth_callback'
                ))
            );

            $promise->client->enqueue($request, function($response) use($promise, $resolve, $reject) {
                if ($response->getResponseCode() === 200) {
                    $resolve($response->getBody()->toString());
                }
            });

            $promise->client->send();

        }, $this->client))->then(function($data) {
            parse_str($data, $array);
            var_dump($array);
            # $promise->model->setArray($array);
        });
    }
}
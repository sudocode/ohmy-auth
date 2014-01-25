<?php namespace ohmy\Auth1\Promise;

use ohmy\Auth1\Promise,
    ohmy\Auth1\SignedRequest,
    http\Client;

class Promise3L extends Promise {

    private $client;
    private $model;

    public function __construct($model, $callback, $client=null) {
        parent::__construct($callback);
        $this->model = $model;
        $this->client = ($client) ?  $client : new Client;
    }

    public function request($url, $success, $failure, $options) {
        $promise = $this;
        return new Promise3L($this->model, function($resolve, $reject) use($promise, $url, $options) {

            $model = $promise->model;

            # check session
            if ($model->get('oauth_token')) {
                $resolve();
                return;
            }

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
                    'oauth_version',
                    'oauth_callback'
                ))
            );

            $promise->client->enqueue($request, function($response) use($promise, $resolve, $reject) {
                echo '<pre>';
                var_dump($response->getResponseCode());
                echo '</pre>';
                if ($response->getResponseCode() === 200) {
                    $string = $response->getBody()->toString();
                    parse_str($string, $array);
                    var_dump($array);
                    $promise->model->setArray($array);
                    $resolve($array);
                }
            });
            $promise->client->send();
        }, $this->client);
    }

    public function authorize($url, $success, $failure, $options) {
        $promise = $this;
        return new Promise3L($this->model, function($resolve, $reject) use($promise, $url, $options) {

            $model = $promise->model;

            # check session
            if ($model->get('oauth_token') && $model->get('oauth_verifier')) {
                $resolve();
                return;
            }

            $location = sprintf(
                'Location: %s?oauth_token=%s',
                $url,
                $model->get('oauth_token')
            );
            header($location);
            exit();
        }, $this->client);
    }

    public function access($url, $success, $failure, $options) {
        $promise = $this;
        echo '<pre>';
        var_dump($this->model);
        echo '</pre>';
        echo 'accessing</br>';
        return new Promise3L($this->model, function($resolve, $reject) use($promise, $url, $options) {
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
                    'oauth_verifier'
                ))
            );

            echo 'made signed request</br>';

            $promise->client->enqueue($request, function($response) use($promise, $resolve, $reject) {
                echo 'inside request callback</br>';
                var_dump($response->getBody()->toString());
                if ($response->getResponseCode() === 200) {
                    $string = $response->getBody()->toString();
                    parse_str($string, $array);
                    var_dump($array);
                    echo 'got access token';
                    $promise->model->setArray($array);
                    $resolve($array);
                }
            });
            $promise->client->send();
        }, $this->client);
    }
}

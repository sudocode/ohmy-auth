<?php namespace ohmy\Auth2\Flow\ThreeLegged;

use ohmy\Auth\Promise,
    http\Client\Request;

class Authorize extends Promise {

    public function __construct($callback, $client=null) {
        parent::__construct($callback);
        $this->client = ($client) ?  $client : new Client;
    }

    public function access($url, $options) {
        $promise = $this;
        return new Access(function($resolve, $reject) use($promise, $url, $options) {
            $promise->client->enqueue($url, function($response) use($promise, $resolve, $reject) {
                echo 'finished access';
                echo '<pre>';
                var_dump($response->getbody()->tostring());
                echo '</pre>';
                if ($response->getresponsecode() === 200) {
                    $resolve($response->getbody()->tostring());
                }
            });

            $promise->client->send();
        });
    }
}
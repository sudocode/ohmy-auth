<?php require_once __DIR__ . '/../vendor/autoload.php';

use ohmy\Auth1;

Auth1::init(2)
     ->set('key', 'key')
     ->set('secret', 'secret')
     ->request('http://term.ie/oauth/example/request_token.php')
     ->access('http://term.ie/oauth/example/access_token.php')
     ->then(function($data) {
         var_dump($data);
     })
     ->catch(function($data) {
     });

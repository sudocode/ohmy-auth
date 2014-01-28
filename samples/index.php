<?php require('vendor/autoload.php');

use ohmy\Auth1\TwoLegged,
    ohmy\Auth1\ThreeLegged;

$three = new ThreeLegged(function($resolve, $reject) {

    $oauth = array(
        'oauth_callback'           => 'http://cloud.sudoco.de/',
        'oauth_callback_confirmed' => $_SESSION['oauth_callback_confirmed'],
        'oauth_consumer_key'       => 'fslonecyQdKajG1bBgnqw9Jl4faxGz0p7wGhKGr56qoNLmF6VR',
        'oauth_consumer_secret'    => 'ndrGx5S9ubohYwhJm0ZdreKHbkAmI6T8X6VNFPy0SXNUPAOqgx',
        'oauth_nonce'              => md5(mt_rand()),
        'oauth_signature_method'   => 'HMAC-SHA1',
        'oauth_timestamp'          => time(),
        'oauth_token'              => $_REQUEST['oauth_token'],
        'oauth_token_secret'       => $_SESSION['oauth_token_secret'],
        'oauth_verifier'           => $_REQUEST['oauth_verifier'],
        'oauth_version'            => '1.0'
    );

    foreach($oauth as $key => $val) {
        $oauth[$key] = rawurlencode($val);
    }

    echo '<pre>';
    var_dump($oauth);
    echo '</pre>';

    $resolve($oauth);
});

$tumblr = $three->request('http://www.tumblr.com/oauth/request_token')
                ->authorize('http://www.tumblr.com/oauth/authorize')
                ->access('http://www.tumblr.com/oauth/access_token');

/*
$two = new TwoLegged(function($resolve, $reject) {
    $oauth = array(
        'oauth_callback'           => '',
        'oauth_callback_confirmed' => $_SESSION['oauth_callback_confirmed'],
        'oauth_consumer_key'       => 'key',
        'oauth_consumer_secret'    => 'secret',
        'oauth_nonce'              => md5(mt_rand()),
        'oauth_signature_method'   => 'HMAC-SHA1',
        'oauth_timestamp'          => time(),
        'oauth_token'              => $_REQUEST['oauth_token'],
        'oauth_token_secret'       => $_SESSION['oauth_token_secret'],
        'oauth_verifier'           => $_REQUEST['oauth_verifier'],
        'oauth_version'            => '1.0'
    );
    foreach($oauth as $key => $val) {
        $oauth[$key] = rawurlencode($val);
    }

    echo '<pre>';
    var_dump($oauth);
    echo '</pre>';

    $resolve($oauth);
}); 

$termie = $two->request('http://term.ie/oauth/example/request_token.php')
              ->access('http://term.ie/oauth/example/access_token.php');

$termie->GET('http://term.ie/oauth/example/echo_api.php?foo=bar')
       ->then(function($response) {
           echo 'got response</br>';
           var_dump($response);
           return 2;
       })
       ->then(function($response) {
           echo 'after then is</br>';
           var_dump($response);
       });
# var_dump($access->getValue());
*/

echo 'done';

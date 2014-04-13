<?php

/*
 * Copyright (c) 2014, Yahoo! Inc. All rights reserved.
 * Copyrights licensed under the New BSD License.
 * See the accompanying LICENSE file for terms.
 */

use ohmy\Auth1,
    ohmy\Auth2;

class AuthTest extends PHPUnit_Framework_TestCase {

    public function setUp() {}
    public function tearDown() {}

    /*
    public function testYahooRequestToken() {
        $phpunit = $this;
        Auth1::init(3)
             ->set('key', getenv('YAHOO_KEY'))
             ->set('secret', getenv('YAHOO_SECRET'))
             ->set('callback', getenv('CALLBACK'))
             ->request('https://api.login.yahoo.com/oauth/v2/get_request_token')
             ->finally(function($data) use($phpunit) {
                 $phpunit->assertTrue(!empty($data['oauth_token']));
                 $phpunit->assertTrue(!empty($data['oauth_token_secret']));
             });
    }*/

    public function testTwitterRequestToken() {
        $phpunit = $this;
        Auth1::init(3)
             ->set('key', getenv('TWITTER_KEY'))
             ->set('secret', getenv('TWITTER_SECRET'))
             ->set('callback', getenv('CALLBACK'))
             ->request('https://api.twitter.com/oauth/request_token')
             ->finally(function($data) use($phpunit) {
                $phpunit->assertTrue(!empty($data['oauth_token']));
                $phpunit->assertTrue(!empty($data['oauth_token_secret']));
             });
    }

    public function testRequestToken() {
        $phpunit = $this;
        Auth1::init(3)
            ->set('key', getenv('FITBIT_KEY'))
            ->set('secret', getenv('FITBIT_SECRET'))
            ->set('callback', getenv('CALLBACK'))
            ->request('http://api.fitbit.com/oauth/request_token')
            ->finally(function($data) use($phpunit) {
                $phpunit->assertTrue(!empty($data['oauth_token']));
                $phpunit->assertTrue(!empty($data['oauth_token_secret']));
            });
    }
}

<?php

/*
 * Copyright (c) 2014, Yahoo! Inc. All rights reserved.
 * Copyrights licensed under the New BSD License.
 * See the accompanying LICENSE file for terms.
 */

use ohmy\Auth1;

class Auth1Test extends PHPUnit_Framework_TestCase {

    public function setUp() {}
    public function tearDown() {}
    public function testInitTwoLegged() {
        $phpunit = $this;
        Auth1::init(2)
             ->then(function($data) use($phpunit) {
                $phpunit->assertArrayHasKey('oauth_callback', $data);
                $phpunit->assertArrayHasKey('oauth_consumer_key', $data);
                $phpunit->assertArrayHasKey('oauth_consumer_secret', $data);
                $phpunit->assertArrayHasKey('oauth_nonce', $data);
                $phpunit->assertArrayHasKey('oauth_signature_method', $data);
                $phpunit->assertArrayHasKey('oauth_timestamp', $data);
                $phpunit->assertArrayHasKey('oauth_token', $data);
                $phpunit->assertArrayHasKey('oauth_token_secret', $data);
                $phpunit->assertArrayHasKey('oauth_verifier', $data);
                $phpunit->assertArrayHasKey('oauth_version', $data);
            });
    }
    public function testInitThreeLegged() {
        $phpunit = $this;
        Auth1::init(2)
            ->then(function($data) use($phpunit) {
                $phpunit->assertArrayHasKey('oauth_callback', $data);
                $phpunit->assertArrayHasKey('oauth_consumer_key', $data);
                $phpunit->assertArrayHasKey('oauth_consumer_secret', $data);
                $phpunit->assertArrayHasKey('oauth_nonce', $data);
                $phpunit->assertArrayHasKey('oauth_signature_method', $data);
                $phpunit->assertArrayHasKey('oauth_timestamp', $data);
                $phpunit->assertArrayHasKey('oauth_token', $data);
                $phpunit->assertArrayHasKey('oauth_token_secret', $data);
                $phpunit->assertArrayHasKey('oauth_verifier', $data);
                $phpunit->assertArrayHasKey('oauth_version', $data);
            });
    }

}

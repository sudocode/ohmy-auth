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
        Auth1::init(2)
             ->then(function($data) {
                $this->assertArrayHasKey('oauth_callback', $data);
                $this->assertArrayHasKey('oauth_consumer_key', $data);
                $this->assertArrayHasKey('oauth_consumer_secret', $data);
                $this->assertArrayHasKey('oauth_nonce', $data);
                $this->assertArrayHasKey('oauth_signature_method', $data);
                $this->assertArrayHasKey('oauth_timestamp', $data);
                $this->assertArrayHasKey('oauth_token', $data);
                $this->assertArrayHasKey('oauth_token_secret', $data);
                $this->assertArrayHasKey('oauth_verifier', $data);
                $this->assertArrayHasKey('oauth_version', $data);
            });
    }
    public function testInitThreeLegged() {
        Auth1::init(2)
            ->then(function($data) {
                $this->assertArrayHasKey('oauth_callback', $data);
                $this->assertArrayHasKey('oauth_consumer_key', $data);
                $this->assertArrayHasKey('oauth_consumer_secret', $data);
                $this->assertArrayHasKey('oauth_nonce', $data);
                $this->assertArrayHasKey('oauth_signature_method', $data);
                $this->assertArrayHasKey('oauth_timestamp', $data);
                $this->assertArrayHasKey('oauth_token', $data);
                $this->assertArrayHasKey('oauth_token_secret', $data);
                $this->assertArrayHasKey('oauth_verifier', $data);
                $this->assertArrayHasKey('oauth_version', $data);
            });
    }

}

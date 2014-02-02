<?php

/*
 * Copyright (c) 2014, Yahoo! Inc. All rights reserved.
 * Copyrights licensed under the New BSD License.
 * See the accompanying LICENSE file for terms.
 */

use ohmy\Auth2;

class Auth2Test extends PHPUnit_Framework_TestCase {

    public function setUp() {}
    public function tearDown() {}
    public function testInitThreeLegged() {
        Auth2::init(3)
            ->then(function($data) {
                $this->assertArrayHasKey('client_id', $data);
                $this->assertArrayHasKey('client_secret', $data);
                $this->assertArrayHasKey('redirect_uri', $data);
                $this->assertArrayHasKey('code', $data);
                $this->assertArrayHasKey('scope', $data);
                $this->assertArrayHasKey('state', $data);
            });
    }

}

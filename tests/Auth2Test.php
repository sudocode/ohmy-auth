<?php

/*
 * Copyright (c) 2014, Yahoo! Inc. All rights reserved.
 * Copyrights licensed under the New BSD License.
 * See the accompanying LICENSE file for terms.
 */

use ohmy\Auth2;
use ohmy\OhmyAuth;

class Auth2Test extends PHPUnit_Framework_TestCase {

    public function setUp() {}
    public function tearDown() {}
    public function testInitThreeLegged() {
        $phpunit = $this;
        OhmyAuth::init(new Auth2, 3)
            ->then(function($data) use($phpunit) {
                $phpunit->assertArrayHasKey('client_id', $data);
                $phpunit->assertArrayHasKey('client_secret', $data);
                $phpunit->assertArrayHasKey('redirect_uri', $data);
                $phpunit->assertArrayHasKey('code', $data);
                $phpunit->assertArrayHasKey('scope', $data);
                $phpunit->assertArrayHasKey('state', $data);
            });
    }

}

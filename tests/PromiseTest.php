<?php

/*
 * Copyright (c) 2014, Yahoo! Inc. All rights reserved.
 * Copyrights licensed under the New BSD License.
 * See the accompanying LICENSE file for terms.
 */

use ohmy\Auth\Promise;

class PromiseTest extends PHPUnit_Framework_TestCase {

    public function setUp(){}
    public function tearDown(){}

    public function testPromiseResolve()
    {

        $test = $this;

        $promise = new Promise(function($resolve) {
            $resolve('helloWorld');
        });

        $promise->then(function($data) use($test) {
            $test->assertEquals($data, 'helloWorld');
        });

    }
}

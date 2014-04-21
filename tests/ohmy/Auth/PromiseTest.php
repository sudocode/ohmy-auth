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

    public function testStaticResolve() {
        $phpunit = $this;
        $promise = Promise::resolve(0);
        $promise->then(function($data) use($phpunit) {
            $phpunit->assertEquals($data, 0);
        }, function($data) use($phpunit) {
            $phpunit->fail('This should not run!');
        });
    }

    public function testStaticReject() {
        $phpunit = $this;
        $promise = Promise::reject(0);
        $promise->then(function($data) use($phpunit) {
            $phpunit->fail('This should not run!');
        }, function($data) use($phpunit) {
            $phpunit->assertEquals($data, 0);
        });
    }

    public function testResolve() {

        $phpunit = $this;

        $promise = new Promise(function($resolve) {
            $resolve(0);
        });

        $promise->then(function($data) use($phpunit) {
            $phpunit->assertEquals($data, 0);
        }, function($data) use($phpunit) {
            $phpunit->fail('This should not run!');
        });

    }

    public function testReject() {

        $phpunit = $this;

        $promise = new Promise(function($resolve, $reject) {
            $reject(0);
        });

        $promise->then(function($data) use($phpunit)  {
            $phpunit->fail('This should not run!');
        }, function($data) use($phpunit) {
            $phpunit->assertEquals($data, 0);
        });
    }

    public function testCatchWithResolve() {

        $phpunit = $this;

        $promise = new Promise(function($resolve, $reject) {
            $resolve(0);
        });

        $promise->then(function($data) use($phpunit)  {
            $phpunit->assertEquals($data, 0);
        }, function($data) use($phpunit) {
            $phpunit->fail('This should not run!');
        })
        ->catch(function($data) use($phpunit) {
            $phpunit->fail('This should not run!');
        });

    }

    public function testCatchWithReject() {

        $phpunit = $this;

        $promise = new Promise(function($resolve, $reject) {
            $reject(0);
        });

        $promise->then(function($data) use($phpunit)  {
            $phpunit->fail('This should not run!');
        }, function($data) use($phpunit) {
            $phpunit->assertEquals($data, 0);
            return $data + 1;
        })
        ->catch(function($data) use($phpunit) {
            $phpunit->assertEquals($data, 1);
        });

    }

    public function testValueAfterCatchWithResolve() {

        $phpunit = $this;

        $promise = new Promise(function($resolve, $reject) {
            $resolve(0);
        });

        $promise->then(function($data) use($phpunit) {
            $phpunit->assertEquals($data, 0);
            return $data + 1;
        }, function($data) use($phpunit) {
            $phpunit->fail('This should not run!');
        })
        ->catch(function($data) use($phpunit) {
            $phpunit->fail('This should not run!');
        })
        ->then(function($data) use($phpunit) {
            $phpunit->assertEquals($data, 1);
        });

    }

    public function testValueAfterCatchWithReject() {

        $phpunit = $this;

        $promise = new Promise(function($resolve, $reject) {
            $reject(0);
        });

        $promise->then(function($data) use($phpunit) {
            $phpunit->fail('This should not run!');
        }, function($data) use($phpunit) {
            $phpunit->assertEquals($data, 0);
            return $data + 1;
        })
        ->catch(function($data) use($phpunit) {
            $phpunit->assertEquals($data, 1);
            return $data + 1;
        })
        ->then(function($data) use($phpunit) {
            $phpunit->assertEquals($data, 2);
        });

    }

    public function testFinallyAfterResolve() {

        $phpunit = $this;

        $promise = new Promise(function($resolve) {
            $resolve(0);
        });

        $promise->then(function($data) use($phpunit) {
            $phpunit->assertEquals($data, 0);
            return $data + 1;
        }, function($data) {
            $phpunit->fail('This should not run!');
        })
        ->finally(function($data) use($phpunit) {
            $phpunit->assertEquals($data, 1);
        });
    }

    public function testFinallyAfterReject() {

        $phpunit = $this;

        $promise = new Promise(function($resolve, $reject) {
            $reject(0);
        });

        $promise->then(function($data) use($phpunit)  {
            $phpunit->fail('This should not run!');
        }, function($data) use($phpunit) {
            $phpunit->assertEquals($data, 0);
            return $data + 1;
        })
        ->catch(function($data) use($phpunit) {
            $phpunit->assertEquals($data, 1);
            return $data + 1;
        })
        ->finally(function($data) use($phpunit) {
            $phpunit->assertEquals($data, 2);
        });
    }
}

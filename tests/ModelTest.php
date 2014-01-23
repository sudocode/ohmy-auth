<?php

/*
 * Copyright (c) 2014, Yahoo! Inc. All rights reserved.
 * Copyrights licensed under the New BSD License.
 * See the accompanying LICENSE file for terms.
 */

use ohmy\Auth1\Model;

class ModelTest extends PHPUnit_Framework_TestCase {
    /**
     * @var Model
     */
    private $model;

    public function setUp()
    {
        $this->model = new Model(array());
    }

    public function tearDown()
    {
        $this->model = null;
    }

    public function testHelloWorld()
    {
        $this->assertEquals('Hello World', 'Hello World');
    }
}

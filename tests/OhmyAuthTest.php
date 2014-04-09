<?php

use ohmy\Auth1,
    ohmy\Auth2,
    ohmy\OhmyAuth;

/**
 * Static and nonstatic test. uses Oauth1/Oauth2 by injection.
 */
class OhmyAuthTest extends PHPUnit_Framework_TestCase
{
    public function setUp() {}
    public function tearDown() {}

    public function ObjectProvider()
    {
        return array(
            array(
                new Auth1, 2, 'ohmy\\Auth1\\Flow\\TwoLegged'
            ),
            array(
                new Auth1, 3, 'ohmy\\Auth1\\Flow\\ThreeLegged'
            ),
            array(
                new Auth2, 3, 'ohmy\\Auth2\\Flow\\ThreeLegged'
            )
        );
    }

    /**
     * @dataProvider ObjectProvider
     */
    public function testOhmyAuthStatic($object, $flow, $class)
    {
        $auth = OhmyAuth::init($object, $flow);

        $this->assertInstanceOf($class, $auth);
    }

    /**
     * @dataProvider ObjectProvider
     */
    public function testOhmyAuthNonStatic($object, $flow, $class)
    {
        $auth = new OhmyAuth($object, $flow);
        $auth = $auth->init();

        $this->assertInstanceOf($class, $auth);
    }

}

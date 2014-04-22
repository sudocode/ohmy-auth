<?php

use ohmy\Auth;



class AuthTest extends PHPUnit_Framework_TestCase
{
    public function setUp() {}
    public function tearDown() {}

    public function provider()
    {
        $auth1TwoLegged = array(
            array(
                'key'    => 'dummy-key',
                'secret' => 'dummy-secret',
            ),
            'ohmy\\Auth1\\Flow\\TwoLegged'
        );

        $auth1ThreeLegged = array(
            array(
                'key'      => 'dummy-key',
                'secret'   => 'dummy-secret',
                'callback' => 'dummy-callback',
            ),
            'ohmy\\Auth1\\Flow\\ThreeLegged'
        );

        $auth2ThreeLegged = array(
            array(
                'id'       => 'dummy-id',
                'secret'   => 'dummy-secret',
                'redirect' => 'dummy-redirect',
            ),
            'ohmy\\Auth2\\Flow\\ThreeLegged'
        );


        return array(
            $auth1TwoLegged,
            $auth1ThreeLegged,
            $auth2ThreeLegged,
        );

    }

    /**
     * @dataProvider provider
     */
    public function testRunProtocolReturn($clientCredentials, $expected)
    {
        $protocol = Auth::init($clientCredentials);

        $this->assertInstanceOf($expected, $protocol);

    }
}

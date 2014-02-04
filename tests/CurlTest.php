<?php

/*
 * Copyright (c) 2014, Yahoo! Inc. All rights reserved.
 * Copyrights licensed under the New BSD License.
 * See the accompanying LICENSE file for terms.
 */

class CurlTest extends PHPUnit_Framework_TestCase {

    private $curl;

    public function setUp(){

        error_log(getenv('OA'));

        $curl = $this->getMock('ohmy\Http\Curl\Request');
        $response = $this->getMockBuilder('ohmy\Http\Curl\Response')
                         ->setConstructorArgs(array(function($resolve, $reject) {
                             $resolve("HTTP\\/1.1 200 OK\r\nAccess-Control-Allow-Origin: *\r\nContent-Type: application\\/json; charset=ISO-8859-1\r\nDate: Sat, 01 Feb 2014 20:16:34 GMT\r\nServer: Google Frontend\r\nCache-Control: private\r\nAlternate-Protocol: 80:quic,80:quic\r\nTransfer-Encoding: chunked\r\n\r\n{\"hello\": \"world\"}\n");
                         }))
                         ->getMock();

        # mock response
        $response->expects($this->any())
                 ->method('then')
                 ->with($this->callback(function($r) use($response) {
                     $json = json_decode($response->text, 2);
                     return isset($json['hello']);
                 }))
                 ->will($this->returnSelf());

        # mock GET
        $curl->expects($this->any())
             ->method('GET')
             ->will($this->returnValue($response));

        # mock POST
        $curl->expects($this->any())
            ->method('POST')
            ->will($this->returnValue($response));

        $this->curl = $curl;
    }

    public function tearDown(){
        $this->curl = null;
    }

    public function testCurlGet() {
        $this->curl->GET('http://foo.com/')
                   ->then(function($data) {});
    }

    public function testCurlPost() {
        $this->curl->POST('http://foo.com/')
                   ->then(function($data) {});
    }
}

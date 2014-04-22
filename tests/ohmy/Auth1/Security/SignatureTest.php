<?php
/*
 * Copyright (c) 2014, Yahoo! Inc. All rights reserved.
 * Copyrights licensed under the New BSD License.
 * See the accompanying LICENSE file for terms.
 */

use ohmy\Auth1\Security\Signature;

class SignatureTest extends PHPUnit_Framework_TestCase {

    private $oauth;

    public function setUp(){
        $this->oauth = array(
            'oauth_callback'           => 'http://foo.com/callback',
            'oauth_consumer_key'       => 'key',
            'oauth_consumer_secret'    => 'secret',
            'oauth_nonce'              => 'abcdefghijk123',
            'oauth_signature_method'   => 'HMAC-SHA1',
            'oauth_timestamp'          => '1391674154',
            'oauth_version'            => '1.0'
        );
    }
    public function tearDown(){
        $this->oauth = null;
    }
    public function testSignatureQueryString() {
        $signature = new Signature('POST', 'http://bar.com/', $this->oauth);
        $this->assertEquals($signature->getQueryString(), 'oauth_callback=http%3A%2F%2Ffoo.com%2Fcallback&oauth_consumer_key=key&oauth_nonce=abcdefghijk123&oauth_signature_method=HMAC-SHA1&oauth_timestamp=1391674154&oauth_version=1.0');
    }

    public function testSignatureBaseString() {
        $signature = new Signature('POST', 'http://bar.com/', $this->oauth);
        $this->assertEquals($signature->getBaseString(), 'POST&http%3A%2F%2Fbar.com%2F&oauth_callback%3Dhttp%253A%252F%252Ffoo.com%252Fcallback%26oauth_consumer_key%3Dkey%26oauth_nonce%3Dabcdefghijk123%26oauth_signature_method%3DHMAC-SHA1%26oauth_timestamp%3D1391674154%26oauth_version%3D1.0');
    }

    public function testSigningKey() {
        $signature = new Signature('POST', 'http://bar.com/', $this->oauth);
        $this->assertEquals($signature->getSigningKey(), 'secret&');
    }

    public function testSignature() {
        $signature = new Signature('POST', 'http://bar.com/', $this->oauth);
        $this->assertEquals($signature->getSignature(), '3L7HyQyZzFoNaoCYOuoBh9qiYbQ=');
    }

    public function testEverything() {
        $signature = new Signature('POST', 'http://bar.com/', $this->oauth);
        $this->assertEquals($signature.'', 'OAuth oauth_callback="http://foo.com/callback", oauth_consumer_key="key", oauth_nonce="abcdefghijk123", oauth_signature="3L7HyQyZzFoNaoCYOuoBh9qiYbQ%3D", oauth_signature_method="HMAC-SHA1", oauth_timestamp="1391674154", oauth_version="1.0"');
    }
}

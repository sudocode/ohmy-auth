<?php namespace ohmy\Auth1\ThreeLegged;

/*
 * Copyright (c) 2014, Yahoo! Inc. All rights reserved.
 * Copyrights licensed under the New BSD License.
 * See the accompanying LICENSE file for terms.
 */

use ohmy\Auth\Promise;

class Access extends Promise {

   public function GET($url, $options) {
       $this->request('GET', $url, $options);
   }

   public function POST($url, $options) {
       $this->request('POST', $url, $options);
   }

}

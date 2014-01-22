/*
 * Copyright (c) 2014, Yahoo! Inc. All rights reserved.
 * Copyrights licensed under the New BSD License.
 * See the accompanying LICENSE file for terms.
 */
<?php namespace ohmy\Auth1\Flow;

    use ohmy\Auth1\Flow\OneLegged,
        ohmy\Auth1\Flow\TwoLegged,
        ohmy\Auth1\Flow\ThreeLegged;

    class Factory {

        public static function construct($type, $params, $model) {
            $flow = null;
            switch($type) {
                case 1:
                    $flow = new OneLegged(
                        $model,
                        $params['url']
                    );
                    break;
                case 2: 
                    $flow = new TwoLegged(
                        $model,
                        $params['urls']['request_token'],
                        $params['urls']['access_token']
                    );
                    break;
                case 3:
                    $flow = new ThreeLegged(
                        $model,
                        $params['urls']['request_token'],
                        $params['urls']['authorize'],
                        $params['urls']['access_token']
                    );
                    break;
                default:
            }
            return $flow;
        }

    }

?>

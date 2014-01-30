<?php namespace ohmy\Http;

use ohmy\Http\Curl\Response;

class Curl {

    public function __construct() {
    }

    public function POST($url, $arguments, $headers) {

        $self = $this;
        return new Response(function($resolve, $reject) use($self, $url, $arguments, $headers) {

            # initialize curl
            $handle = curl_init();

            # set curl options
            curl_setopt_array($handle, array(
                CURLOPT_POST       => true,
                CURLOPT_URL        => $url,
                CURLOPT_POSTFIELDS => http_build_query($arguments, '', '&'),
                CURLOPT_HTTPHEADER => $self->_headers($headers),
                CURLOPT_HEADER     => true,
                CURLOPT_RETURNTRANSFER => true
            ));

            # execute curl
            $raw = curl_exec($handle);

            # close curl handle
            curl_close($handle);

            # resolve
            $resolve($raw);
        });
    }

    private function _headers($headers) {
        $output = array();
        if (!$headers) return $output;
        foreach($headers as $key => $value) {
            array_push($output, "$key: $value");
        }
        return $output;
    }
    /*
    public function GET($url, $arguments=null, $headers=null, $callback=null) {

        $request = new Request(array(
            CURLOPT_URL        => "$url?".http_build_query($arguments),
            CURLOPT_HTTPHEADER => self::_headers($headers)
        ));

        $response = new Response(
            $request->exec()
        );

        if (!$callback) return $response;
        else $callback($response);
    }

    public function PST($url, $arguments=null, $headers=null, $callback=null) {

        $request = new Request(array(
            CURLOPT_POST       => true,
            CURLOPT_URL        => $url,
            CURLOPT_POSTFIELDS => http_build_query($arguments, '', '&'),
            CURLOPT_HTTPHEADER => self::_headers($headers)
        ));

        $response = new Response(
            $request->exec()
        );

        if (!$callback) return $response;
        else $callback($response);
    }
    */

}

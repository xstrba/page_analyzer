<?php

namespace App\Http\Controllers;

use App\Http\Requests\UrlRequest;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Exception;

class HeaderController extends Controller
{

    public function __construct()
    {

        $this->middleware('url.modif');

    }

    /**
     * Set array with header to accept encoding,
     * get header from a page, and checks its content
     *
     * @param  \App\Http\Requests\UrlRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function getHeaders(UrlRequest $request)
    {

        if( !function_exists('curl_version') )
            throw new Exception('Server error: Curl required');

        $client = new Client();
        $response = $client->get($request->url, [
            'version' => 2.0,
            'headers' => [
                                'Accept-Encoding' => 'gzip',
                                'Access-Control-Allow-Origin' => '*',
                        ],
            'decode_content' => false,
        ]);

        $gzip = 0;

        if( $response->hasHeader('Content-Encoding') )
            if( preg_match('/gzip/', $response->getHeader('Content-Encoding')[0]) )
                $gzip = 1;

        $data = [
                    'url' => $request->url,
                    'code' => $response->getStatusCode(),
                    'httpSup' => (float) $response->getProtocolVersion() >= 2.0 ? 1 : 0,
                    'gzipSup' => $gzip,
                    // 'response' => $http_response_header,
                ];

        return response()->view('response.headers', $data, 200);

    }//getHeaders

}

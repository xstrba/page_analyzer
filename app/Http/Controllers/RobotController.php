<?php

namespace App\Http\Controllers;

use App\Http\Requests\UrlRequest;
use Exception;
use GuzzleHttp\Exception\GuzzleException;
use \GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7;
use GuzzleHttp\Client;

class RobotController extends Controller
{

    public function __construct()
    {

        $this->middleware('url.modif');

    }

    /**
     * Checks if robots are allowed on a page
     * according to robots.txt, just checks if path is presnet
     * in file
     *
     * @param  $content content of a page
     * @return 1 if indexing allowed, 0 if not
     */
    public function robots(UrlRequest $request)
    {

        //empty array of agents which are disallowed
        $robotsDisallowed = array();

        //get host and path from url
        $parsed = parse_url($request->url);
        if( array_key_exists("path", $parsed) )
            $path = $parsed["path"];
        else $path = '/';

        if( !preg_match('/^www/', $parsed["host"]) )
            $parsed["host"] = 'www.'.$parsed["host"];

        //get base url/robots.txt
        $url = $parsed["scheme"].'://'.$parsed["host"].'/robots.txt';

        //guzzle client
        $client = new Client();

        try {

            $response = $client->get($url);

        } catch(GuzzleException $e) {

            if( $e->getCode() === 404 )
                return response()->view('response.robots', [
                                        'robotsDisallowed' => array(),
                                        'link' => "",
                                        ] ,200);

        }

        //empty array containing agents and all disallowes for them
        $array = array();

        $stream = $response->getBody();
        while ( !$stream->eof() ) {

            //read line from stream
            $line = \GuzzleHttp\Psr7\readline($stream, 1024);
            //check for User-agent: ...
            if( preg_match('/(?<=^User-agent:).+\n/', $line, $agents) )
            {

                //store it in array
                $agent = $agents[0];
                $agent = trim($agent);
                if( !isset($array[$agent]) )
                    $array[$agent] = array();
                continue;

            }

            //check for Disallowed: ... and store it in array
            if( preg_match('/(?<=^Disallow:).+\n/', $line, $pattDis) && is_string($agent))
                array_push($array[$agent], $pattDis[0]);

            if( preg_match('/(?<=^Allow:).+\n/', $line, $pattAll) && is_string($agent))
            {



            }

        }//while stream

        //loop through all agents
        foreach ($array as $bot => $disallows)
        {

            //lopp through all disallowed patterns for agent
            foreach ($disallows as $key => $patt)
            {

                $patt = trim($patt);

                $patt = str_replace('\*', '.*', preg_quote($patt, '/'));
                // $patt = preg_replace('/\n/', '', $patt);

                if( preg_match('/'.$patt.'/', $path, $res) && !in_array($bot, $robotsDisallowed) )
                {

                    //nobody knows what * means
                    if($bot === "*")
                        $bot = 7; //magic
                    array_push($robotsDisallowed, $bot);

                }

            } //foreach disallows

        } //foreach array

        return response()->view('response.robots', [
                                    'robotsDisallowed' => $robotsDisallowed,
                                    'link' => $url
                                    ] ,200);

    }//robots

}

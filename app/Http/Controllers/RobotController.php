<?php

namespace App\Http\Controllers;

use App\Http\Requests\UrlRequest;
use Exception;

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
    public function getRobots(UrlRequest $request)
    {

        $robotsAllow = 1;
        $parsed = parse_url($request->url);
        if( array_key_exists("path", $parsed) )
            $path = $parsed["path"];
        else $path = '/';

        //get base url/robots.txt
        // preg_match('/^.+:\/\/[^\/]*/', $url, $absUrl);
        // $url = $absUrl[0].'/robots.txt';
        $url = $parsed["scheme"].'://'.$parsed["host"].'/robots.txt';

        //get content of robots
        $robotsContent = @file_get_contents($url);
        if( $robotsContent != null )
        {

            preg_match_all('/Disallow:.*\n/', $robotsContent, $disallows);
            foreach ($disallows[0] as $key => $disallow)
            {

                preg_match('/(?<=: ).*\n/', $disallow, $patt);
                if( !empty($patt) )
                {

                    $patt = str_replace('\*', '.*', preg_quote($patt[0], '/'));
                    $patt = preg_replace('/\n/', '', $patt);

                    // return $path;
                    if( preg_match('/'.$patt.'/', $path, $res) )
                        $robotsAllow = 0;

                }//if empty

            } //foreach disallows

        } //if robots content
        else $url = "";

        return response()->view('response.robots', [
                                    'robotsAllowed' => $robotsAllow,
                                    'link' => $url
                                    ] ,200);

    }//checkRobots()

}

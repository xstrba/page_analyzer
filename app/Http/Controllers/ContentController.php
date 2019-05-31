<?php

namespace App\Http\Controllers;

use App\Http\Requests\UrlRequest;
use Exception;

class ContentController extends Controller
{

    public function __construct()
    {

        $this->middleware('url.modif');

    }

    /**
     * Get content of a page, checks images
     * and their alt properties and checks
     * robots indexing.
     *
     * @param  \App\Http\Requests\UrlRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function getContents(UrlRequest $request)
    {

        $content = file_get_contents($request->url);

        preg_match_all('/<img.*?>/', $content, $images);

        $alts = 0;
        $altsEmpty = 0;

        foreach ($images[0] as $image) {

            if( preg_match('/(?<=alt=")[^"]*/', $image, $res) )
            {

                $alts++;
                if( empty($res) )
                    $altsEmpty++;

            }
        }

        $robotsAllow = $this->checkRobots($content, $request->url);

        $data = [
                    'imgCount' => sizeof($images[0]),
                    'altsMiss' => sizeof($images[0]) - $alts,
                    'altsEmpty' => $altsEmpty,
                    'robotsAllowed' => $robotsAllow,
                    'content' => $content
                ];

        return response()->view('response.contents', $data, 200);

    }//getContents

    /**
     * Checks if robots are allowed on a page
     * according to its meta tags
     *
     * @param  $content content of a page
     * @return 1 if indexing allowed, 0 if not
     */
    public function checkRobots($content, $url)
    {

        //check for meta tag in content
        preg_match('/\<meta.+name=.+robots.+content=.+noindex/', $content, $meta);
        if(!empty($meta))
            return 0;

        return 1;

    }//checkRobots()

}

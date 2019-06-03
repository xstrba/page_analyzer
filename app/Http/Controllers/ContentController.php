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

        // return response(dd($content));
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

        $data = [
                    'imgCount' => sizeof($images[0]),
                    'altsMiss' => sizeof($images[0]) - $alts,
                    'altsEmpty' => $altsEmpty,
                    'robotsDisallowed' => $this->checkRobots($content),
                    'content' => $content
                ];

        return response()->view('response.contents', $data, 200);

    }//getContents

    /**
     * Checks if robots are allowed on a page
     * according to its meta tags
     *
     * @param  $content content of a page
     * @return 0 if indexing allowed, 1 if not
     */
    private function checkRobots($content)
    {

        //check for meta tag in content
        preg_match('/\<meta.+name=.+robots.+content=.+noindex/', $content, $meta);
        if( preg_match('/\<meta[^\n]*name="[^\n"]*robots[^\n>]*/', $content, $meta) )
        {

            if( preg_match('/content="[^"\n]*noindex[^\n>]*/', $meta[0]) )
                return 1;

        }

        return 0;

    }//checkRobots()

}

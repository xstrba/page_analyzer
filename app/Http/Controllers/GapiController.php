<?php

namespace App\Http\Controllers;

use App\Http\Requests\UrlRequest;
use Exception;

class GapiController extends Controller
{

    public function __construct()
    {

        $this->middleware('url.modif');

    }

    /**
     * Get content of google page insights api
     * and send final score and audits affecting this
     * score
     *
     * @param  \App\Http\Requests\UrlRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function getInsights(UrlRequest $request)
    {

        $content = file_get_contents('https://www.googleapis.com/pagespeedonline/v5/runPagespeed?url='.
                                    $request->url);
        $content = json_decode($content);

        $score = $content->lighthouseResult->categories->performance->score;

        if($score >= 0.9)
        {
            $borderVal = 'border-success';
            $textVal = 'text-success';
        }
        elseif($score < 0.9 && $score >= 0.75)
        {
            $borderVal = 'border-warning';
            $textVal = 'mtext-warning';
        }
        elseif($score < 0.75 && $score >= 0.5)
        {
            $borderVal = 'border-dark';
            $textVal = 'text-muted';
        }
        elseif($score < 0.5 && $score >= 0)
        {
            $borderVal = 'border-danger';
            $textVal = 'text-danger';
        }

        $data= [

            "score" => $score,
            "audits" => [
                'First Contentful Paint'=>
                $content->lighthouseResult->audits->{'first-contentful-paint'}->displayValue,
                'Speed Index'=> $content->lighthouseResult->audits->{'speed-index'}->displayValue,
                'Time To Interactive'=>
                    $content->lighthouseResult->audits->{'interactive'}->displayValue,
                'First Meaningful Paint'=>
                    $content->lighthouseResult->audits->{'first-meaningful-paint'}->displayValue,
                'First CPU Idle'=>
                    $content->lighthouseResult->audits->{'first-cpu-idle'}->displayValue,
                'Estimated Input Latency'=>
                    $content->lighthouseResult->audits->{'estimated-input-latency'}->displayValue
                ],
            "border" => $borderVal,
            "text" => $textVal

        ];

        return response()->view('response.gapi', $data, 200);

    }//getInsights()

}

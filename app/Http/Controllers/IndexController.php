<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IndexController extends Controller
{

    /**
     * Display home page
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('home');

    }//index()

}

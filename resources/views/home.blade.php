@extends('layouts.app')

@section('csslinks')
    <link rel="stylesheet" href="/css/main.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')

    <noscript>
        <div class="noscript">
            Enable javascript to use this app
        </div>
    </noscript>
    <div class="container mt-4">
        <div class="d-inline-block col-lg-6 col-md-8 col-sm-12">
        <div class="heading text-center">
            <h1 class="text-center">Page analyzer</h1>

            <a data-toggle="collapse" href="#collapseHint" role="button"
                aria-expanded="false" aria-controls="collapseHint">
                ?
            </a>
            <p class="collapse text-break" id="collapseHint">
                Application works only with <span>http</span> or <span>https</span>.<br/>
                After submit, app gets header from page and checks <span>response code</span>,
                if <span>http/2</span> and <span>gzip</span> are supported. <br/>
                Then gets content of page and finds all <span>img tags</span>, and checks if they have
                <span>alt property</span> set and if it is empty. Also checks presence of
                <span>robots meta tag</span> with noindex set.<br/>
                Then app checks existance of <span>host/robots.txt</span> file and
                checks if given path is disallowed. Looks only for <span>"Disallow:..."</span> lines.
                <span>If robots.txt disallow url it remains disallowed even if meta tag allows it.</span>

                At last app displays result from Google <span>PageSpeed</span> Insights.
            </p>
        </div>

        <div class="form">
            <div class="col-12 text-center d-none" id="loader">
                L<div class="loader"></div>ADING
            </div>
            <form class="text-right" id="urlForm" method="post"
            onsubmit="submitForm(event)">
                @csrf
                <div class="form-group mb-2">
                    <label for="input-url" class="sr-only">Url to analyze</label>
                    <input type="text" class="form-control form-control-lg" id="inputUrl" oninput="checkInput(this)"
                        name="url" value="" placeholder="Enter url" required>
                </div>
                <button type="submit" id="urlBtn" name="button" class="btn my-btn btn-lg" disabled>Analyze</button>
            </form>
        </div>

        <div class="result" id="result">

        </div>
        </div>
    </div>

    <script type="text/javascript" src="/js/main.js"></script>

@endsection

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
        <h1 class="text-center heading">Page analyzer</h1>

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

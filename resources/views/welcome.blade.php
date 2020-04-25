<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ env('APP_NAME') }}</title>
        <link rel="stylesheet" type="text/css" href="/css/app.css" />
        <link rel="stylesheet" type="text/css" href="/css/animate.css" />
    </head>
    <body>
        <div id="app">
            <div class="load-wrapper">
                <div class="loader">
                    <div class="lds-dual-ring"></div>
                </div>
            </div>
        </div>
    </body>
    <script src="/js/app.js"></script>
</html>

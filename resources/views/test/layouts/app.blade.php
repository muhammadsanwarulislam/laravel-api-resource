<!doctype html>
<html lang="{{App::getLocale()}}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <link rel="icon" type="image/png" href="{{asset('img/favicon.png')}}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{asset('img/favicon.png')}}">


    <!-- Shortcut Icon -->
    <link rel="shortcut icon" href="{{asset('img/favicon.png')}}">
    <link rel="icon" type="image/ico" href="{{asset('img/favicon.png')}}" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') | {{ config('app.name') }}</title>

    @stack('before-styles')

    <link rel="stylesheet" href="{{ asset('css/backend.css') }}">
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <link href="https://fonts.googleapis.com/css?family=Ubuntu&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Noto+Sans+Bengali+UI&display=swap" rel="stylesheet" />
    <style>body{font-family:Ubuntu,"Noto Sans Bengali UI", Arial, Helvetica, sans-serif}</style>

    @stack('after-styles')


</head>
<body class="c-app">


    <div class="c-wrapper">


        <div class="c-body">
            <main class="c-main">
                <div class="container-fluid">

                    <div class="animated fadeIn">

                        <!-- Main content block -->
                        @yield('content')
                        <!-- / Main content block -->

                    </div>
                </div>
            </main>
        </div>



        <!-- Scripts -->
        @stack('before-scripts')

        <script src="{{ asset('js/backend.js') }}"></script>

        @stack('after-scripts')
        <!-- / Scripts -->

    </body>
    </html>

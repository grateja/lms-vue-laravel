<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Laravel</title>

        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    </head>
    <body>
        <div id="app">
            <nav class="navbar navbar-light navbar-sticky">
                <div class="container">
                    <ul>
                        <router-link tag="li" class="nav-item" to="/" exact><a class="nav-link">Home</a></router-link>
                        <router-link tag="li" class="nav-item" to="/books"><a class="nav-link">Books</a></router-link>
                        <router-link tag="li" class="nav-item" to="/issue"><a class="nav-link">Issue</a></router-link>
                        <router-link tag="li" class="nav-item" to="/archives"><a class="nav-link">Archives</a></router-link>
                        <router-link tag="li" class="nav-item" to="/requests"><a class="nav-link">Requests</a></router-link>
                    </ul>
                </div>
            </nav>
            <ul>
            </ul>
            <router-view></router-view>
        </div>
        <script src="{{ asset('js/app.js') }}"></script>
    </body>
</html>

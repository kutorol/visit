<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <script>
        const App = {
            User: {
                {{--name: `{{ auth()->name }}`--}}
            }
        }
    </script>
    <!-- Styles -->
    @viteReactRefresh
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div id="app"></div>
</body>
</html>

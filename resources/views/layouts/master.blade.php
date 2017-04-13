<!DOCTYPE html>

<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title')</title>
        <!-- WebPage .ico-->
        <link href="{{ asset('favicon.ico') }}" rel="shortcut icon" />
        <!-- Styles -->
        <link rel="stylesheet" href="css/app.css">

    </head>

    <body>

        @yield('nav')

		@yield('content')

    	<!--  javascript -->
        <script src="js/app.js"></script>

     </body>
</html>

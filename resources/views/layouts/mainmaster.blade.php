<!DOCTYPE html>

<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title')</title>

        <!-- Bootstrap 3.3.7 -->
        {{-- <link rel="stylesheet" href="{{asset('bootstrap/css/bootstrap.min.css')}}"> --}}
        <!-- Font Awesome -->
        <link rel="stylesheet" href="{{asset('font-awesome/css/font-awesome.min.css')}}">
        <!-- Ionicons -->
        <link rel="stylesheet" href="{{asset('ionicons/css/ionicons.min.css')}}">
        <!-- Theme style -->
        <link rel="stylesheet" href="{{asset('dist/css/AdminLTE.min.css')}}">
        <!-- AdminLTE Skins Modificada Novasys-->
        <link rel="stylesheet" href="{{asset('dist/css/skins/skin-blue.css')}}">
        <!-- Custom CSS -->
        <link rel="stylesheet" href="{{asset('css/custom.css')}}">
        <!-- Styles -->
        <link rel="stylesheet" href="css/app.css">

    </head>

    <body>

		@yield('content')

    	<!--  javascript -->
        <script src="js/app.js"></script>

     </body>
</html>

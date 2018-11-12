<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <link rel="stylesheet" href="{{ mix('css/app.css')}}">
    @yield('css')
</head>
<body>
@include('layouts.navbars._default')
<div class="container main-content" id="app">
    @yield('content')

    <notifications group="notifications" position="bottom right">asdf</notifications>
</div>

<script src="{{mix('js/app.js')}}"></script>
@yield('javascript')
</body>
</html>

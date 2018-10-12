<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{csrf_token()}}" />

        <link rel="stylesheet" type="text/css" href="/css/app.css"/>
        <!-- <link href="https://unpkg.com/ionicons@4.4.4/dist/css/ionicons.min.css" rel="stylesheet"> -->

        <title>Forum</title>
    </head>
    <body class="frost">
      <div class="main" id="app">
        @section('app')
        @show
      </div>
      <div class="footer">
        <h1 class="typ s pd-s c">Designed by <a href="http://waweru.co.ke">Dave</a></h1>
      </div>

      <script src="/js/app.js"></script>
    </body>
</html>

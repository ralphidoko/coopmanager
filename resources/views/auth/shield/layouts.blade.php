<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cooperative Manager</title>

    <!-- CSS -->
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:400,100,300,500">
    <link rel="stylesheet" href="{{ asset ('custom') }}/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset ('custom') }}/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset ('custom') }}/css/form-elements.css">
    <link rel="stylesheet" href="{{ asset ('custom') }}/css/style.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Favicon and touch icons -->
    <link rel="shortcut icon" href="{{ asset ('custom')}}/ico/favicon.png">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{ asset ('custom')}}/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{ asset ('custom')}}/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{ asset ('custom')}}/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="{{ asset ('custom')}}/ico/apple-touch-icon-57-precomposed.png">

</head>

<body>
@yield('content')

<!-- Javascript -->
<script src="{{ asset ('custom') }}/js/jquery-1.11.1.min.js"></script>
<script src="{{ asset ('custom') }}/bootstrap/js/bootstrap.min.js"></script>
<script src="{{ asset ('custom') }}/js/jquery.backstretch.min.js"></script>
<script src="{{ asset ('custom') }}/js/scripts.js"></script>

<!--[if lt IE 10]>
    <script src="{{ asset ('custom')}}/js/placeholder.js"></script>
<![endif]-->
<!-- Footer -->
{{--<footer>--}}
{{--    <div class="container">--}}
{{--        <div class="row">--}}
{{--            <div class="col-sm-8 col-sm-offset-2">--}}
{{--                <div class="footer-border"></div>--}}
{{--                <p>Designed By <a href="http://isosystemss.com" target="_blank">ISOSYSTEMS</a>.</p>--}}
{{--            </div>--}}

{{--        </div>--}}
{{--    </div>--}}
{{--</footer>--}}

</body>

</html>

<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/favicon.ico">
    <title>技术合伙人沙龙</title>
    <link href="{{ elixir('css/app.css') }}" rel="stylesheet">
</head>

<body>
    <div class="container">
        <nav class="navbar navbar-default navbar-tall" role="navigation">
            <div class="navbar-header">
                <button class="navbar-toggler hidden-md-up pull-xs-right" type="button" data-toggle="collapse" data-target="#global-nav">
                    &#9776;
                </button>
                <a class="navbar-brand" href="/">技术合伙人</a>
            </div>
            <div class="collapse navbar-toggleable-sm" id="global-nav">
                <ul class="nav navbar-nav"></ul>
                <ul class="nav navbar-nav pull-md-right">
                </ul>
            </div>
        </nav>
    </div>
    @yield('content')
    
    <script src="{{ elixir('js/vendors.js') }}"></script>
</body>

</html>

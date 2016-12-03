<!DOCTYPE html>
<html lang="ja">
    <head>
    <meta name="viewport" content="width=device-width,initial-scale=1">
        <link rel="stylesheet" type="text/css" href="/css/app.css">
        <link rel="stylesheet" type="text/css" href="/css/default.css">
        <title>@yield('title')</title>
    </head>
<body>
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">yyUIUX</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav navbar-right">
        <form class="navbar-form navbar-left">
          <div class="form-group">
            <input type="text" class="form-control" placeholder="Search">
          </div>
          <button type="submit" class="btn btn-default">Submit</button>
        </form>
        <li>
          <a href="#">Login</a>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
<!-- /.nav -->

<div class="container-fluid">
<!-- <div class="row"> -->
  <div class = "col-sm-2 col-xs-12">
    <div class="side-menu">
      <ul class="nav nav-pills nav-stacked">
        <li class="nav-item">
          <a class="nav-link active" href="#">Link</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Link</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Link</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Link</a>
        </li>
      </ul>
    </div>
    <div class="side-menu">
      <ul class="nav nav-pills nav-stacked">
        <li class="nav-item">
          <a class="nav-link active" href="#">カテゴリー</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">カテゴリー</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">カテゴリー</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">カテゴリー</a>
        </li>
      </ul>
    </div>
  </div>
  <div class = "col-sm-8 col-xs-12">
    <p>contents</p>
  </div>

  <div class="col-sm-2 col-xs-12">
    <div class="side-menu">
      <ul class="nav nav-pills nav-stacked">
        <li class="nav-item">
          <a class="nav-link active" href="#">ユーザー情報</a>
        </li>
      </ul>
    </div>
    <div class="side-menu">
      <ul class="nav nav-pills nav-stacked">
        <li class="nav-item">
          <a class="nav-link active" href="#">Twitter</a>
        </li>
      </ul>
    </div>
    <div class="side-menu">
      <ul class="nav nav-pills nav-stacked">
        <li class="nav-item">
          <a class="nav-link active" href="#">ランキング</a>
        </li>
      </ul>
    </div>
  </div>

<!-- </div> -->
        @section('sidebar')
        @show

        
            @yield('content')
        </div>
        <script type="text/javascript" src = "/js/app.js"></script>
    </body>
</html>
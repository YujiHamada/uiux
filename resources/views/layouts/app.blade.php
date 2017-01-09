<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Laravel') }}</title>

  <!-- Styles -->
  <link rel="stylesheet" href="/css/app.css">
  <link rel="stylesheet" href="/css/styles.css">
  @yield('css')

  <!-- Scripts -->
  <script>
    window.Laravel = {!! json_encode(['csrfToken' => csrf_token(), ]) !!}
  </script>
</head>

<body>
  <div id="app">
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
          <a class="navbar-brand" href="/">yyUIUX</a>
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
            <!-- Authentication Links -->
            @if (Auth::guest())
            <li><a href="{{ url('/login') }}">Login</a></li>
            <li><a href="{{ url('/register') }}">Register</a></li>
            @else
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                {{ Auth::user()->name }} <span class="caret"></span>
              </a>

              <ul class="dropdown-menu" role="menu">
                <li>
                  <a href="{{ action('UserController@show', ['username' => Auth::user()->name]) }}">
                    マイページ
                  </a>
                </li>
                <li>
                  <a href="{{ url('/logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    ログアウト
                  </a>
                  <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                  </form>
                </li>
              </ul>
            </li>
            @endif
          </ul>
        </div><!-- /.navbar-collapse -->
      </div><!-- /.container-fluid -->
    </nav>
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
      <?php foreach($categories as $category): ?>
        <li class="nav-item">
          <a class="nav-link active" href="#">{{$category->name}}</a>
        </li>
      <?php endforeach; ?>
      </ul>
      </div>
    </div>
    <div class = "col-sm-8 col-xs-12">
      @if (session('flash_message'))
          <div class="flash_message" onClick="this.classList.add('hidden')">
              {{ session('flash_message') }}
          </div>
      @endif
      @yield('content')
    </div>
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

  <!-- Scripts -->
  <script src="/js/app.js"></script>
  @yield('js')
</body>
</html>

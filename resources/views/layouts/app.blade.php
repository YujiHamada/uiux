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
  <link rel="stylesheet" href="/css/mystyles.css">
  @yield('css')

  <!-- Scripts -->
  <script>
    window.Laravel = {!! json_encode(['csrfToken' => csrf_token(), ]) !!}
  </script>
</head>

<body>
  <div id="app">
    <!-- ナビゲーションバー -->
    @section('navigationBar')
      <nav class="navbar navbar-toggleable-md navbar-inverse bg-inverse">
        <a class="navbar-brand" href="/">yyUIUX</a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
              <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Link</a>
            </li>
            <li class="nav-item">
              <a class="nav-link disabled" href="#">Disabled</a>
            </li>
          </ul>
          <form class="form-inline">
            <input class="form-control mr-sm-2" type="text" placeholder="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
          </form>
          <!-- ログイン / ユーザネーム -->
          <ul class="navbar-nav form-inline mx-2">
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
                  <a href="{{ action('UserController@show', Auth::user()->name) }}">
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
        </div>
      </nav>
    @show
    <!-- ナビゲーションバー以下 -->
    <div class="container-fluid m-3">
      <div class="row justify-content-center">
        <div class="col-9">
          <div class="row">
            <!-- 左サイドバー -->
            @section('leftSideBar')
              <nav class="col-2 bg-warning">
                <ul class="nav nav-pills flex-column">
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
                <ul class="nav nav-pills flex-column">
                <?php foreach($categories as $category): ?>
                  <li class="nav-item">
                    <a class="nav-link" href="#">{{$category->name}}</a>
                  </li>
                <?php endforeach; ?>
                </ul>
              </nav>
            @show
            <!-- 中央メインコンテンツ -->
            <div class="col">
              @yield('content')
            </div>
            <!-- 右サイドバー -->
            @section('rightSideBar')
              <nav class="col-2 bg-info">
                <ul class="nav nav-pills flex-column">
                  <li class="nav-item">
                    <a class="nav-link active" href="#">ユーザー情報</a>
                  </li>
                </ul>
                <ul class="nav nav-pills flex-column">
                  <li class="nav-item">
                    <a class="nav-link active" href="#">Twitter</a>
                  </li>
                </ul>
                <ul class="nav nav-pills flex-column">
                  <li class="nav-item">
                    <a class="nav-link active" href="#">ランキング</a>
                  </li>
                </ul>
              </nav>
            @show
          </div>
        </div>

      </div>

    </div>
    <!-- フッター -->
    @section('footer')
      <!-- 未作成 -->
    @show
  </div>
  <!-- Scripts -->
  <script src="/js/app.js"></script>
  @yield('js')
</body>
</html>

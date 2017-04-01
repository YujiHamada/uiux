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
  @section('head')
    <link rel="stylesheet" href="/css/app.css">
    <link rel="stylesheet" href="/css/bootstrap-social.css"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"/>
    <link rel="stylesheet" href="/css/cropper.css">
    <link rel="stylesheet" href="/css/croppermain.css">
    <link rel="stylesheet" href="/css/mystyles.css">
  @show

  <!-- Scripts -->
  <script>
    window.Laravel = {!! json_encode(['csrfToken' => csrf_token(), ]) !!}
  </script>
</head>

<body class="yy-bg-body">
  <div id="app">
    <!-- ナビゲーションバー -->
    @section('navigationBar')
      <div class="row justify-content-center yy-bg-midnightblue">
        <nav class="col-10 navbar navbar-toggleable-md navbar-inverse">
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
            <form class="form-inline my-0">
              <input class="form-control mr-2" type="text" placeholder="Search">
              <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
            <!-- ログイン / ユーザネーム -->
            <ul class="navbar-nav form-inline mx-2">
              @if (Auth::guest())
              <li><a href="{{ url('/login') }}">Login</a></li>
              <li><a href="{{ url('/register') }}">Register</a></li>
              @else
              <span class="yy-avatar-thumbnail-img mx-2" style="background-image: url({{ asset(Auth::user()->avatar_image_path) }})"></span>
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
      </div>
    @show
    <!-- ナビゲーションバー以下 -->
    <div class="container-fluid my-3">
      <div class="row justify-content-center">
        <div class="col-10 px-0">
          <div class="row justify-content-center">
            <!-- 左サイドバー -->
            @section('leftSideBar')
              <nav class="col-2 px-0 mx-3">
                <ul class="nav nav-pills flex-column">
                  <li class="nav-item yy-outline-bottom">
                    <p class="nav-link yy-bg-midnightblue text-white my-0" >LeftSidebar</p>
                  </li>
                  <li class="nav-item yy-outline-bottom">
                    <a class="nav-link yy-bg-sidebar active" href="#">Link</a>
                  </li>
                  <li class="nav-item yy-outline-bottom">
                    <a class="nav-link yy-bg-sidebar" href="#">Link</a>
                  </li>
                  <li class="nav-item yy-outline-bottom">
                    <a class="nav-link yy-bg-sidebar" href="#">Link</a>
                  </li>
                  <li class="nav-item yy-outline-bottom">
                    <a class="nav-link yy-bg-sidebar" href="#">Link</a>
                  </li>
                </ul>
                <ul class="nav nav-pills flex-column">
                <?php foreach($categories as $category): ?>
                  <li class="nav-item yy-outline-bottom">
                    <a class="nav-link yy-bg-sidebar" href="#">{{$category->name}}</a>
                  </li>
                <?php endforeach; ?>
                </ul>
              </nav>
            @show
            <!-- 中央メインコンテンツ -->
            @section('content')
            @show
            <!-- 右サイドバー -->
            @section('rightSideBar')
              <nav class="col-2 px-0 mx-3">
                <ul class="nav nav-pills flex-column">
                  <li class="nav-item yy-outline-bottom">
                    <p class="nav-link yy-bg-midnightblue text-white my-0" >RightSidebar</p>
                  </li>
                  <li class="nav-item yy-outline-bottom">
                    <a class="nav-link yy-bg-sidebar" href="#">ユーザー情報</a>
                  </li>
                  <li class="nav-item yy-outline-bottom">
                    <a class="nav-link yy-bg-sidebar" href="#">Twitter</a>
                  </li>
                  <li class="nav-item yy-outline-bottom">
                    <a class="nav-link yy-bg-sidebar" href="#">ランキング</a>
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
  @section('foot')
    <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js"></script>
    <script src="/js/app.js"></script>
    <script src="/js/cropper.js"></script>
    <script src="/js/croppermain.js"></script>
    <script src="/js/myscripts.js"></script>
  @show
</body>
</html>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <link rel="icon" type="image/x-icon" href="{{ asset('images/app_images/yyuxlogo.ico') }}">
  <title>{{ config('app.name') }}</title>

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

<body class="yy-body yy-bg-body d-flex flex-column">

  {{-- consoleでvueのエラーがでるので以下を残す。使途不明。 --}}
  <div id="app"></div>

  <!-- ナビゲーションバー -->
  <header>
    @section('navigationBar')

          <nav class="navbar navbar-toggleable-md navbar-inverse fixed-top yy-bg-midnightblue">
            <div class="container col-8 px-0">
                <a class="navbar-brand" href="/">yyUX</a>
                <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                  <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                  <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                      <a class="nav-link" href="#">Link</a>
                    </li>
                  </ul>
                  <form class="form-inline my-0" method="GET" action="{{ url('/timeline') }}">
                    <input class="form-control mr-2" type="text" placeholder="Search" value="{{ $searchWords or '' }}" name="searchWords" required>
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
            </div>
          </nav>


    @show
  </header>
  <!-- ナビゲーションバー以下 -->
  <main class="mb-auto">
    <div class="container-fluid my-3">
      <div class="row justify-content-center">
        <div class="col-8">
          <div class="row justify-content-center">
            <!-- 左サイドバー -->
            @section('leftSideBar')

            @show
            <!-- 中央メインコンテンツ -->
            @section('content')
            @show
            <!-- 右サイドバー -->
            @section('rightSideBar')
              <nav class="col-3 px-0 mx-3">
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
                <ul class="nav nav-pills flex-column">
                @foreach($tags as $tag)
                  <li class="nav-item yy-outline-bottom">
                    <a class="nav-link yy-bg-sidebar" href="/timeline?tagId={{ $tag->id }}">{{ $tag->name }}</a>
                  </li>
                @endforeach
                </ul>
              </nav>
            @show
          </div>
        </div>
      </div>
    </div>
  </main>
  <!-- フッター -->
  <footer class="footer">
    @section('footer')
      <div class="container-fluid">
        <div class="row justify-content-center bg-inverse">
          <div class="col-8 m-0 p-0">
            <div class="row mx-0 p-0 mt-3">
              <div class="col-3 py-2 px-3">
                <ul class="text-white">
                  <li>
                    利用規約
                  </li>
                  <li>
                    プライバシーボリシー
                  </li>
                  <li>
                    その他1
                  </li>
                  <li>
                    その他1
                  </li>
                  <li>
                    その他3
                  </li>
                </ul>
              </div>
              <div class="col-3 py-2 px-3">
                <ul class="text-white">
                  <li>
                    よくある質問
                  </li>
                  <li>
                    <a class="text-white" href="/contact">お問い合わせ</a>
                  </li>
                </ul>
              </div>
              <div class="col-6 py-2 px-3 text-white d-flex align-items-center">
                <div class="d-block">
                  <h1 class="pb-1">
                    yyUX
                  </h1>
                  <p class="d-inline">
                    <a class="text-white" href="/about">yyUXについて</a>
                  </p>
                  <span class="px-3">|</span>
                  <p class="d-inline">
                    <a class="text-white" href="http://yyux.hatenablog.com/" target="_blank">
                      公式ブログ
                    </a>
                  </p>
                  <span class="px-3">|</span>
                  <p class="d-inline">
                    <a class="text-white" href="https://twitter.com/yyUX_info?lang=ja" target="_blank">
                      <span class="fa fa-twitter"></span>Twitter (@yyUX_info)
                    </a>
                  </p>
                </div>
              </div>
            </div>

          </div>
          <div class="col-8 py-2 px-3">
            <p class="m-0 text-white text-center">
              Copyright© 2017 yyUX All Rights Reserved.
            </p>
          </div>
        </div>
      </div>
    @show
  </footer>
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

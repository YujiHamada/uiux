

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
  {{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous"> --}}
  <link rel="stylesheet" href="/css/styles.css">
  <link rel="stylesheet" href="/css/userstyles.css">
  @yield('css')

  <!-- Scripts -->
  <script>
    window.Laravel = {!! json_encode(['csrfToken' => csrf_token(), ]) !!}
  </script>
</head>

<body>
  <div id="user">
    <nav class="navbar navbar-inverse navbar-fixed-top">
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
        <div class="collapse navbar-collapse">
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
    <div class="container-fluid" style="padding:100px 0">
      <div class="col-sm-offset-1 col-sm-10 row">

        <div class="col-sm-3 col-xs-12 sidebar">
          <div class="profile">
            <div class="media">
              <a class="media-left" href="#">
                <img class="media-object img-rounded img-responsive" src="{{Config::get('const.IMAGE_FILE_DIRECTORY')}}" alt="がぞう">
              </a>
              <div class="media-body">
                <h4 class="media-heading">{{ $user->name }}</h4>
                <p>{{ $user->name }}</p>
              </div>
            </div>
            <div class="profileStatus">
              <div class="row">
                {{-- <div class="col-sm-6 col-xs-12">
                  <button type="button" class="btn btn-primary">Primary</button>
                </div> --}}
                <div class="col-sm-12 col-xs-12">
                  <p>投稿数</p>
                  <p>10</p>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-6 col-xs-12">
                  <p>フォロー数</p>
                  <p>123</p>
                </div>
                <div class="col-sm-6 col-xs-12">
                  <p>フォロー数</p>
                  <p>987</p>
                </div>
              </div>
            </div>
          </div>
          <ul class="nav nav-sidebar">
            <li><a href="#">アクティビティ</a></li>
            <li><a href="#">プロフィールを編集</a></li>
            <li><a href="#">パスワードを設定</a></li>
            <li><a href="#">通知</a></li>
          </ul>
        </div>
        <div class="col-sm-9 col-xs-12">
          @if (session('flash_message'))
              <div class="flash_message" onClick="this.classList.add('hidden')">
                  {{ session('flash_message') }}
              </div>
          @endif
          @yield('content')
        </div>
      </div>
    </div>
  <!-- Scripts -->
  <script src="/js/app.js"></script>
  {{-- <script
  src="https://code.jquery.com/jquery-3.1.1.min.js"
  integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
  crossorigin="anonymous"></script>
  <script
  src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
  integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
  crossorigin="anonymous"></script> --}}
  @yield('js')
</body>
</html>

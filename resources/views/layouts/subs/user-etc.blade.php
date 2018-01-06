@if (Auth::guest())
    <a class="text-white" href="{{ url('/login') }}">ログイン</a>
    <div class="text-white mx-1">/</div>
    <a class="text-white" href="{{ url('/register') }}">新規登録</a>
@else
    <div class="btn-group">
        <a href="#" class="fa fa-user-o fa-2x d-block d-md-none text-white" aria-hidden="true"  data-toggle="dropdown" role="button" aria-expanded="false"></a>
        @if(isset(Auth::user()->avatar_image_path))
            <span class="yy-avatar-thumbnail-img mx-2 d-none d-md-block" style="background-image: url({{ asset(Auth::user()->avatar_image_path) }})"></span>
        @else
            <span class="yy-avatar-thumbnail-img mx-2 d-none d-md-block" style="background-image: url({{ asset(Config::get('const.APP_IMAGES_DIRECTORY') . 'yyuxlogo_white.png') }})"></span>
        @endif
        <a href="#" class="dropdown-toggle text-white d-none d-md-block" data-toggle="dropdown" role="button" aria-expanded="false">
            {{ Auth::user()->name }} <span class="caret"></span>
        </a>

        <div class="dropdown-menu dropdown-menu-right">
            <a class="dropdown-item" href="{{ action('UserController@show', Auth::user()->name) }}">
                マイページ
            </a>
            <a class="dropdown-item" href="{{ url('/logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                ログアウト
            </a>
            <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>
        </div>
    </div>
@endif

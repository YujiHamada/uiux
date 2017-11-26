@extends('layouts.auth')

@section('content')
  <div class="col">
      <div class="panel panel-default">
          <div class="panel-heading"><h1>ログイン</h1></div>
          <div class="panel-body">
              <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                  {{ csrf_field() }}

                  <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                      <label for="email" class="col control-label">メールアドレス</label>

                      <div class="col">
                          <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                          @if ($errors->has('email'))
                              <span class="help-block">
                                  <strong>{{ $errors->first('email') }}</strong>
                              </span>
                          @endif
                      </div>
                  </div>

                  <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                      <label for="password" class="col control-label">パスワード</label>

                      <div class="col">
                          <input id="password" type="password" class="form-control" name="password" required>

                          @if ($errors->has('password'))
                              <span class="help-block">
                                  <strong>{{ $errors->first('password') }}</strong>
                              </span>
                          @endif
                      </div>
                  </div>

                  <div class="form-group">
                      <div class="col-md-6 col-md-offset-4">
                          <div class="checkbox">
                              <label>
                                  <input type="checkbox" name="remember"> 次回から自動でログインする
                              </label>
                          </div>
                      </div>
                  </div>

                  <div class="form-group">
                      <div class="col-md-8 col-md-offset-4">
                          <button type="submit" class="btn btn-primary">
                              ログイン
                          </button>

                          <a class="btn btn-link" href="{{ url('/password/reset') }}">
                              パスワードを忘れた方はこちら
                          </a>
                      </div>
                  </div>
              </form>
          </div>
      </div>
  </div>
  <div class="col">
    <a class="btn btn-block btn-social btn-twitter"  href="login/twitter">
        <span class="fa fa-twitter"></span> Twitterでログイン
    </a>
    <a class="btn btn-block btn-social btn-facebook" href="login/facebook">
        <span class="fa fa-facebook"></span> Facebookでログイン
    </a>
    <a class="btn btn-block btn-social btn-google"  href="login/google">
        <span class="fa fa-google"></span> Googleでログイン
    </a>
    <a class="btn btn-block btn-social btn-github"  href="login/github">
        <span class="fa fa-github"></span> Githubでログイン
    </a>
  </div>
@endsection

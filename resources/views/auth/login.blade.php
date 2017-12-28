@extends('layouts.auth')

@section('content')
  <div class="col-md">
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
                      <div class="col">
                          <div class="checkbox">
                              <label>
                                  <input type="checkbox" name="remember"> 次回から自動でログインする
                              </label>
                          </div>
                      </div>
                  </div>

                  <div class="form-group">
                      <div class="col">
                          <button type="submit" class="btn btn-primary yy-non-double-click">
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
  @include('auth.subs.social-login')
@endsection

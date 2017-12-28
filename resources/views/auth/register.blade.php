@extends('layouts.auth')

@section('content')
  <div class="col-md">
      <div class="panel panel-default">
          <div class="panel-heading">新規登録</div>
          <div class="panel-body">
              <form class="form-horizontal" role="form" method="POST" action="{{ url('/register') }}">
                  {{ csrf_field() }}

                  <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                      <label for="name" class="col control-label">ユーザー名</label>

                      <div class="col">
                          <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                          @if ($errors->has('name'))
                              <span class="help-block">
                                  <strong>{{ $errors->first('name') }}</strong>
                              </span>
                          @endif
                      </div>
                  </div>

                  <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                      <label for="email" class="col control-label">メールアドレス</label>

                      <div class="col">
                          <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

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
                      <label for="password-confirm" class="col control-label">パスワード(確認)</label>

                      <div class="col">
                          <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                      </div>
                  </div>

                  <div class="form-group">
                      <div class="col">
                          <button type="submit" class="btn btn-primary">
                              登録する
                          </button>
                      </div>
                  </div>
              </form>
          </div>
      </div>
  </div>
  @include('auth.subs.social-login')
@endsection

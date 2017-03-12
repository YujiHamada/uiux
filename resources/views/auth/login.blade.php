@extends('layouts.auth')

@section('content')
  <div class="col">
      <div class="panel panel-default">
          <div class="panel-heading">Login</div>
          <div class="panel-body">
              <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                  {{ csrf_field() }}

                  <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                      <label for="email" class="col control-label">E-Mail Address</label>

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
                      <label for="password" class="col control-label">Password</label>

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
                                  <input type="checkbox" name="remember"> Remember Me
                              </label>
                          </div>
                      </div>
                  </div>

                  <div class="form-group">
                      <div class="col-md-8 col-md-offset-4">
                          <button type="submit" class="btn btn-primary">
                              Login
                          </button>

                          <a class="btn btn-link" href="{{ url('/password/reset') }}">
                              Forgot Your Password?
                          </a>
                      </div>
                  </div>
              </form>
          </div>
      </div>
  </div>
  <div class="col">
    <a class="btn btn-block btn-social btn-twitter"  href="login/twitter">
        <span class="fa fa-twitter"></span> Sign in with Twitter
    </a>
    <a class="btn btn-block btn-social btn-facebook" href="login/facebook">
        <span class="fa fa-facebook"></span> Sign in with Facebook
    </a>
    <a class="btn btn-block btn-social btn-google"  href="login/google">
        <span class="fa fa-google"></span> Sign in with Google
    </a>
    <a class="btn btn-block btn-social btn-github"  href="login/github">
        <span class="fa fa-github"></span> Sign in with Github
    </a>
  </div>
@endsection

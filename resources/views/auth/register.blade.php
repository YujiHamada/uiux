@extends('layouts.auth')

@section('content')
  <div class="col">
      <div class="panel panel-default">
          <div class="panel-heading">Register</div>
          <div class="panel-body">
              <form class="form-horizontal" role="form" method="POST" action="{{ url('/register') }}">
                  {{ csrf_field() }}

                  <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                      <label for="name" class="col control-label">Name</label>

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
                      <label for="email" class="col control-label">E-Mail Address</label>

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
                      <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>

                      <div class="col">
                          <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                      </div>
                  </div>

                  <div class="form-group">
                      <div class="col">
                          <button type="submit" class="btn btn-primary">
                              Register
                          </button>
                      </div>
                  </div>
              </form>
          </div>
      </div>
  </div>
  <div class="col">
    <a class="btn btn-block btn-social btn-twitter"  href="login/twitter">
        <span class="fa fa-twitter"></span> Sign up with Twitter
    </a>
    <a class="btn btn-block btn-social btn-facebook" href="login/facebook">
        <span class="fa fa-facebook"></span> Sign up with Facebook
    </a>
    <a class="btn btn-block btn-social btn-google"  href="login/google">
        <span class="fa fa-google"></span> Sign up with Google
    </a>
    <a class="btn btn-block btn-social btn-github"  href="login/github">
        <span class="fa fa-github"></span> Sign up with Github
    </a>
  </div>
@endsection

@extends('layouts.auth')

@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            <div class="panel panel-default">
                <div class="panel-heading">登録</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/register/social') }}">
                        {{ csrf_field() }}

                        <input type="hidden" name="avatar_image_path" value="{{ isset($avatarImagePath) ? $avatarImagePath : old('avatar_image_path') }}">

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">名前</label>

                            <div class="col">
                                <input id="name" type="text" class="form-control" name="name" value="{{ isset($nickname) ? $nickname : old('name') }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">メールアドレス</label>

                            <div class="col">
                                <input id="email" type="email" class="form-control" name="email" value="{{ isset($email) ? $email : old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
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
          <img class="user-avatar" src="{{ asset(isset($avatarImagePath) ? $avatarImagePath : old('avatar_image_path')) }}">
        </div>
    </div>
</div>
@endsection

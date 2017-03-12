@extends('layouts.user')

@section('content')
  <div class="col mx-3">
    <div id="crop-avatar">

      @if (session('flash_message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          {{ session('flash_message') }}
        </div>
      @endif

      <h4>プロフィールを編集</h4>

      <form method="post" action="{{ action('UserController@store') }}" enctype="multipart/form-data">
        {{ csrf_field() }}

        <input type="hidden" name="avatar_image_path" class="avatar-image-path" value="{{ Auth::user()->avatar_image_path }}">
        <div class="form-group row">
          <label class="col-2 col-form-label">ユーザーネーム</label>
          <input type="text" name="name"
            class="col-10 form-control"
            value="{{ Auth::user()->name }}" required autofocus>
          @if ($errors->has('name'))
              <span class="col-10 offset-2 help-block">
                  <strong>{{ $errors->first('name') }}</strong>
              </span>
          @endif
        </div>
        <div class="form-group row">
          <label class="col-2">メールアドレス</label>
          <input type="email" name="email"
            class="col-10 form-control" aria-describedby="emailHelp"
            value="{{ Auth::user()->email }}" required>
          <small class="col-10 offset-2 form-text text-muted">We'll never share your email with anyone else.</small>
          @if ($errors->has('email'))
              <span class="col-10 offset-2 help-block">
                  <strong>{{ $errors->first('email') }}</strong>
              </span>
          @endif
        </div>
        <div class="row form-group">
          <label class="col-2">自己紹介</label>
          <textarea name="biography" class="col-10 form-control" rows="3">{{ Auth::user()->biography }}</textarea>
        </div>
        <div class="row form-group">
          <label class="col-12">プロフィール画像</label>
          <div class="col-10 offset-2">
            <div class="ml-0 avatar-view" title="Change the avatar">
              <img src="{{ asset(old('avatar_image_path') !== null ? old('avatar_image_path') : Auth::user()->avatar_image_path) }}" alt="Avatar">
            </div>
          </div>
        </div>
        <button type="submit" class="btn btn-primary">変更を保存</button>

      </form>

      @include('subs.cropper')

    </div>
  </div>
@endsection

@section('foot')
  @parent
  <script>
  </script>
@endsection

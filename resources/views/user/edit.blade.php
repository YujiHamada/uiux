@extends('layouts.user')

@section('content')
<div class="col mx-3 my-3">
    @include('subs.flash-message-success')

    <h4 class="my-3">プロフィールを編集</h4>

    <form method="post" action="{{ action('UserController@store') }}" enctype="multipart/form-data">
        {{ csrf_field() }}

        <input type="hidden" name="avatar_image_path" class="avatar-image-path" value="{{ Auth::user()->avatar_image_path }}">
        <div class="form-group row">
          <label class="col-3 col-form-label">ユーザーネーム</label>
          <input type="text" name="name" class="col-9 form-control" spellcheck="false" value="{{ Auth::user()->name }}" required autofocus>
          @if ($errors->has('name'))
              <span class="col-9 offset-3 help-block">
                  <strong>{{ $errors->first('name') }}</strong>
              </span>
          @endif
        </div>
        <div class="form-group row">
          <label class="col-3 col-form-label">メールアドレス</label>
          <input type="email" name="email" class="col-9 form-control" aria-describedby="emailHelp" value="{{ Auth::user()->email }}" required>
          @if ($errors->has('email'))
              <span class="col-9 offset-3 help-block">
                  <strong>{{ $errors->first('email') }}</strong>
              </span>
          @endif
        </div>
        <div class="row form-group">
          <label class="col-3 col-form-label">自己紹介</label>
          <textarea name="biography" maxlength="150" class="col-9 form-control" rows="3">{{ Auth::user()->biography }}</textarea>
        </div>
        <div class="row form-group">
          <label class="col-12 col-form-label">プロフィール画像</label>
          <div class="col-9 offset-3 p-0">
            <div class="ml-0 avatar-view" title="画像を変更する">
              <img src="{{ old('avatar_image_path') !== null ? old('avatar_image_path') : ( isset(Auth::user()->avatar_image_path) ? Auth::user()->avatar_image_path : '/images/app_images/yyuxlogo_black.png' ) }}" alt="Avatar">
            </div>
          </div>
        </div>
        <button type="submit" class="yy-pointer mt-2 btn btn-primary btn-block">変更を保存</button>

    </form>
</div>
@endsection

@section('foot')
  @parent
  <script src="/js/cropper.js"></script>
  <script src="/js/croppermain.js"></script>
  <script>
  </script>
@endsection

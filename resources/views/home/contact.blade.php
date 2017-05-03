@extends('layouts.app')

@section('content')
  <div class="col-8 mx-0 px-0">


    <h4 class="py-1">
      お問い合わせ
    </h4>
    <p class="pb-3">
      当サイトに関するお問い合わせや、ご意見、ご感想、ご要望は以下の項目をご記入の上、「送信する」を押してください。
    </p>

    <form method="post" action="{{ action('HomeController@sendContact') }}">
      {{ csrf_field() }}

      <div class="form-group row">
        <label class="col-3 col-form-label">お名前<span class="ml-2 badge badge-danger">必須</span></label>
        <input type="text" name="name" class="col-9 form-control" spellcheck="false" value="{{ Auth::check() ? Auth::user()->name : "" }}" required autofocus>
        @if ($errors->has('name'))
            <span class="col-9 offset-3 help-block">
                <strong>{{ $errors->first('name') }}</strong>
            </span>
        @endif
      </div>

      <div class="form-group row">
        <label class="col-3 col-form-label">メールアドレス<span class="ml-2 badge badge-danger">必須</span></label>
        <input type="email" name="email" class="col-9 form-control" value="{{ Auth::check() ? Auth::user()->email : "" }}" required>
        @if ($errors->has('email'))
            <span class="col-9 offset-3 help-block">
                <strong>{{ $errors->first('email') }}</strong>
            </span>
        @endif
      </div>

      <div class="form-group row">
        <label class="col-3 col-form-label">関連URL<span class="ml-2 badge badge-success">任意</span></label>
        <input type="url" name="url" class="col-9 form-control" placeholder="http://www.example.com/">
        @if ($errors->has('url'))
            <span class="col-9 offset-3 help-block">
                <strong>{{ $errors->first('url') }}</strong>
            </span>
        @endif
      </div>

      <div class="row form-group">
        <label class="col-3 col-form-label">内容<span class="ml-2 badge badge-danger">必須</span></label>
        <textarea name="contact" maxlength="10000" class="col-9 form-control" rows="8" required></textarea>
      </div>

      <div class="d-flex justify-content-center">
        <button type="submit" class="btn btn-primary">送信する</button>
      </div>

    </form>



  </div>
@endsection

@section('rightSideBar')
@endsection

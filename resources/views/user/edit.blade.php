@extends('layouts.user')

@section('content')
    <h4>プロフィールを編集</h4>
    <form>
      <div class="form-group row">
        <label class="col-2 col-form-label">ユーザーネーム</label>
        <div class="col-10">
          <p class="form-control-static">{{ Auth::user()->name }}</p>
        </div>
      </div>
      <div class="form-group row">
        <label class="col-2">メールアドレス</label>
        <input type="email" class="col-10 form-control" aria-describedby="emailHelp" placeholder="Enter email">
        <small class="col-10 offset-2 form-text text-muted">We'll never share your email with anyone else.</small>
      </div>
      <div class="row form-group">
        <label class="col-2">自己紹介</label>
        <textarea class="col-10 form-control" rows="3"></textarea>
      </div>
      <div class="row form-group">
        <label class="col-12">プロフィール画像</label>
      </div>
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    @include('subs.cropper')


@endsection

@section('foot')
  @parent
  <script>
  </script>
@endsection

@extends('layouts.user')


@section('content')
    <h4>プロフィールを編集</h4>
    <form>
      <div class="form-group row">
        <label class="col-2 col-form-label">ユーザーネーム</label>
        <div class="col-10">
          <p class="form-control-static">{{ $user->name }}</p>
        </div>
      </div>
      <div class="form-group row">
        <label class="col-2">メールアドレス</label>
        <input type="email" class="col-10 form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
        <small id="emailHelp" class="col-10 offset-2 form-text text-muted">We'll never share your email with anyone else.</small>
      </div>
      <div class="row form-group">
        <label class="col-2">自己紹介</label>
        <textarea class="col-10 form-control" id="exampleTextarea" rows="3"></textarea>
      </div>
      <div class="row form-group">
        <label class="col-12">プロフィール画像</label>
        <div class="col-12" >
          <img class="img-fluid" style="height: 10rem;" src="{{asset('images/review_images/myimages/apple.png')}}" alt="..."/>
          TODO : 未完成
        </div>
        <div class="col-12">
          <input type="file" class="form-control-file" id="exampleInputFile" aria-describedby="fileHelp">
          <small id="fileHelp" class="form-text text-muted">This is some placeholder block-level help text for the above input. It's a bit lighter and easily wraps to a new line.</small>
        </div>
      </div>
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>

@endsection

@section('js')
<scrit>
</script>
@endsection

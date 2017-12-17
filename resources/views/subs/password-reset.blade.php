<h4 class="my-3">パスワード再設定</h4>

@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif

<form class="form-horizontal" role="form" method="POST" action="{{ url('/password/email') }}">
  {{ csrf_field() }}

  <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
    <p>
      登録されたメールアドレスを入力し、送信してください。
      送信後、パスワードを再設定する案内をメールします。
      メールが届かない場合、迷惑メールやフィルターをご確認ください。
      登録されていないメールアドレスにはメールの送信は行っておりません。
    </p>
    <label for="email" class="control-label">メールアドレス</label>
    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>
    @if ($errors->has('email'))
      <span class="help-block">
        <strong>{{ $errors->first('email') }}</strong>
      </span>
    @endif
  </div>

  <button type="submit" class="yy-pointer mt-2 btn btn-primary btn-block">
    送信する
  </button>

</form>

@extends('layouts.app')

@section('leftSideBar')
  <div class="col-3">
    <div class="card bg-success">
      <img class="card-img-top mx-auto mt-3" src="..." alt="Card image cap">
      <div class="card-block">
        <h4 class="card-title">{{ $user->name}}</h4>
        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
        <a href="#" class="btn btn-primary">Go somewhere</a>
      </div>
    </div>
    {{-- 認証ユーザの場合は、ユーザの設定関連のサイドバーを表示する。 --}}
    @if($user->id == Auth::user()->id)
      <div class="mt-3">
        <nav class="bg-faded">
          <ul class="nav nav-pills flex-column">
            <li class="nav-item">
              <a class="nav-link active" href="#">アクティビィ</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ action('UserController@edit', $user->name) }}">プロフィールを編集</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">パスワードを設定</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">通知</a>
            </li>
          </ul>
        </nav>
      </div>
    @endif
  </div>
@endsection

{{-- 右サイドバーは不要のため、空で上書き --}}
@section('rightSideBar')
@endsection

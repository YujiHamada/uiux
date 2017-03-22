@extends('layouts.app')

@section('leftSideBar')
  <div id="user-left-side-bar" class="col-3 px-0">

    @php
      if(!isset($user)) {
        $user = Auth::user();
      }
    @endphp

    <div class="yy-bg-white yy-outline py-3">
      <div class="mx-3">
        <span class="yy-avatar-img mx-auto d-block" style="background-image: url({{ asset($user->avatar_image_path) }})"></span>
      </div>
      <div class="mx-3">
        <div>
          <h5 class="text-center my-3">{{ $user->name }}</h5>
          <p>{{ $user->biography }}</p>
        </div>
        <div class="py-3">
          <a href="#" class="btn btn-outline-success d-block">Go somewhere</a>
        </div>
        <div>
          <p>
            フォロー数：
            <a href="{{ action('UserController@showFollowing', $user->name) }}">{{ $user->getFollowCount() }}
            </a>
          </p>
          <p>
            フォロワー数：
            <a href="{{ action('UserController@showFollowers', $user->name) }}">
              {{ $user->getFollowerCount() }}
            </a>
          </p>
        </div>
      </div>
    </div>

    {{-- 認証ユーザの場合は、ユーザの設定関連のサイドバーを表示する。 --}}
    @if($user->name == Auth::user()->name)
      <div class="mt-3">
        <nav class="bg-faded">
          <ul class="nav nav-pills flex-column">
            <li class="nav-item yy-outline-bottom">
              <a class="nav-link yy-bg-sidebar" href="{{ action('UserController@show', Auth::user()->name) }}">アクティビィ</a>
            </li>
            <li class="nav-item yy-outline-bottom">
              <a class="nav-link yy-bg-sidebar" href="{{ action('UserController@edit') }}">プロフィールを編集</a>
            </li>
            <li class="nav-item yy-outline-bottom">
              <a class="nav-link yy-bg-sidebar" href="#">パスワードを設定</a>
            </li>
            <li class="nav-item yy-outline-bottom">
              <a class="nav-link yy-bg-sidebar" href="#">通知</a>
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

@extends('layouts.app')

@section('leftSideBar')

  @if($)
    <nav class="col-2 bg-faded">
      <ul class="nav nav-pills flex-column">
        <li class="nav-item">
          <a class="nav-link active" href="#">アクティビィ</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">プロフィールを編集</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">パスワードを設定</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">通知</a>
        </li>
      </ul>
    </nav>
  @endif()
@endsection

@section('rightSideBar')
@endsection

@extends('layouts.app')

@section('leftSideBar')
    <div id="user-left-side-bar" class="col-12 col-lg-4 px-3">

        {{-- 変数$userに値が設定されていない場合、
        変数$userにログイン中のユーザを設定する。 --}}
        @php
            if(Auth::check() && !isset($user)) {
                $user = Auth::user();
            }
        @endphp

        <div class="yy-bg-white yy-outline py-3">
            <div class="mx-3">
                <span class="yy-avatar-img mx-auto d-block" style="background-image: url({{ $user->avatar_image_path or '/images/app_images/yyuxlogo_black.png' }})"></span>
            </div>
            <div class="mx-3">
                <div>
                    <h5 class="text-center my-3">{{ $user->name }}</h5>
                    <p>{{ $user->biography }}</p>
                </div>
                @if(Auth::check())
                    <div class="py-3">
                        @if($user->name == Auth::user()->name)
                            <a href="{{ action('UserController@edit') }}" class="btn btn-outline-success d-block">プロフィールを編集</a>
                        @else
                            <button id="follow-btn" class="btn btn-outline-success btn-block {{ $user->isFollowed() ? 'active' : '' }}" type="button" aria-pressed="true">
                                {{ $user->isFollowed() ? 'フォロー中' : 'フォローする' }}
                            </button>
                        @endif
                    </div>
                @endif
                <div>
                    <p>
                        フォロー数：
                        <a id="follow-count" href="{{ action('UserController@showFollowing', $user->name) }}">
                            {{ $user->getFollowCount() }}
                        </a>
                    </p>
                    <p>
                        フォロワー数：
                        <a id="follower-count" href="{{ action('UserController@showFollowers', $user->name) }}">
                            {{ $user->getFollowerCount() }}
                        </a>
                    </p>
                </div>
            </div>
        </div>

        {{-- 認証ユーザの場合は、ユーザの設定関連のサイドバーを表示する。 --}}
        @if(Auth::check())
            @if($user->name == Auth::user()->name)
                <div class="mt-3">
                    <nav class="bg-light">
                        <ul class="nav nav-pills flex-column">
                            <li class="nav-item yy-outline-bottom">
                                <a class="nav-link yy-bg-sidebar" href="{{ action('UserController@show', Auth::user()->name) }}">アクティビィ</a>
                            </li>
                            <li class="nav-item yy-outline-bottom">
                                <a class="nav-link yy-bg-sidebar" href="{{ action('UserController@edit') }}">プロフィールを編集</a>
                            </li>
                            <li class="nav-item yy-outline-bottom">
                                <a class="nav-link yy-bg-sidebar" href="{{ action('UserController@resetPassword') }}">パスワードを設定</a>
                            </li>
                            <li class="nav-item yy-outline-bottom">
                                <a class="nav-link yy-bg-sidebar" href="{{ action('UserController@showLinkSocial') }}">ソーシャル連携</a>
                            </li>
                            <li class="nav-item yy-outline-bottom">
                                <a class="nav-link yy-bg-sidebar" href="#">通知</a>
                            </li>
                            <li class="nav-item yy-outline-bottom">
                                {{-- <a class="nav-link yy-bg-sidebar" href="{{ Auth::user()->name }}/leave">退会する</a> --}}
                                <a class="nav-link yy-bg-sidebar" href="{{ action('UserController@leave', Auth::user()->name) }}">退会する</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            @endif
        @endif

    </div>
@endsection

{{-- 右サイドバーは不要のため、空で上書き --}}
@section('rightSideBar')
@endsection

@section('foot')
    @parent
    <script>
        $(function() {

            // 画面表示時にフォローボタンの属性を設定
            if($('#follow-btn').hasClass('active')) {
                $('#follow-btn').mouseenter(function() {$(this).text('解除する').css('background-color','red');})
                                .mouseleave(function() {$(this).text('フォロー中').css('background-color','');});
            }

            // フォローボタン押下時イベント。Ajax。
            $('#follow-btn').on('click', function() {
                var name = "{{ $user->name }}";
                $.ajax({
                    url: "/{{ $user->name }}/follow",
                    type:'POST',
                    dataType: 'json',
                    data: {
                        name: name
                    }
                }).done(function(data) {
                    $('#follow-btn').toggleClass('active');

                    // フォローボタンの属性を設定する
                    if(data.isFollow){
                        $('#follower-count').text(data.followerCount);
                        $('#follow-btn').text('フォロー中')
                                .mouseenter(function() {$(this).text('解除する').css('background-color','red');})
                                .mouseleave(function() {$(this).text('フォロー中').css('background-color','');});
                    } else {
                        $('#follower-count').text(data.followerCount);
                        $('#follow-btn').text('フォローする').unbind('mouseenter').unbind('mouseleave').css('background-color','');
                    }

                }).fail(function() {
                    alert('失敗しました');
                });
            });

        });
    </script>
@endsection

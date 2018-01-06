<!DOCTYPE html>
<html lang="ja">
<head>
    @if(env("APP_ENV") == 'production')
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-111357514-1"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', 'UA-111357514-1');
        </script>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    @endif

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" type="image/x-icon" href="{{ asset('images/app_images/yyuxlogo_black.ico') }}">
    <title>{{ $title or config('app.name') }}</title>
    <meta name="description" content="{{ Config::get('const.SITE_DESCRIPTION') }}"/>
    <meta name="keywords" content="{{ Config::get('const.SITE_KEYWORD') }}"/>

    <!-- ogp -->
    <meta property="og:title" content="{{ $title or config('app.name') }}"/>
    <meta property="og:type" content="{{ $ogType or 'website' }}"/>
    <meta property="og:url" content="{{ url()->current() }}"/>
    <meta property="og:image" content="{{ isset($ogImage) ? asset($ogImage) : asset(Config::get('const.APP_IMAGES_DIRECTORY') . 'yyuxlogo_black.ico') }}"/>
    <meta property="og:site_name" content="{{ config('app.name') }}}"/>
    <meta property="og:description" content="{{ Config::get('const.SITE_DESCRIPTION') }}"/>

    <meta name="twitter:card" content="{{ Config::get('const.TWITTER_CARD') }}"/>
    <meta name="twitter:site" content="{{ Config::get('const.TWITTER_ID') }}">

    <!-- Styles -->
    @section('head')
        <link rel="stylesheet" href="/css/app.css">
        <link rel="stylesheet" href="/css/bootstrap-social.css"/>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"/>
        <link rel="stylesheet" href="/css/cropper.css">
        <link rel="stylesheet" href="/css/croppermain.css">
        <link rel="stylesheet" href="/css/mystyles.css">
    @show

    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode(['csrfToken' => csrf_token(), ]) !!}
    </script>
</head>

<body class="yy-body yy-bg-body d-flex flex-column">

    {{-- consoleでvueのエラーがでるので以下を残す。使途不明。 --}}
    <div id="app"></div>

    <!-- ナビゲーションバー -->
    <header>
    @section('navigationBar')

        <nav class="navbar navbar-expand-md navbar-dark fixed-top yy-bg-midnightblue">
            <div class="container d-flex">
                <a class="navbar-brand text-white mr-auto" href="/">
                    <img src="{{ asset('images/app_images/yyuxlogo_white.png') }}" style="height: 1.8rem;" class="mr-2" />
                    yyUX
                </a>
                {{-- <div class="ml-auto"></div> --}}

                <div class="d-flex align-items-center justify-content-end">

                    @include('layouts.subs.search')

                    {{-- ゲストの場合は通知ボタンは表示しない --}}
                    @if (!Auth::guest())
                        @include('layouts.subs.notifications')
                    @endif

                    @include('layouts.subs.user-etc')
                </div>




            </div>
        </nav>
    @show
    </header>

    <!-- ナビゲーションバー以下 -->
    <main class="mb-auto">
        <div id="crop-avatar">
            <div class="container my-3 px-0">
                <div class="row justify-content-center mx-2">
                    <!-- 左サイドバー -->
                    @section('leftSideBar')

                    @show
                    <!-- 中央メインコンテンツ -->
                    @section('content')
                    @show
                    <!-- 右サイドバー -->
                    @section('rightSideBar')
                        <nav class="col-lg-3 px-3">

                            <div class="yy-outline mb-3">
                                <div class="yy-bg-test text-white px-3 py-2">
                                    <p class="m-0">
                                        投稿する
                                    </p>
                                </div>
                                <div class="px-3 py-2">
                                    <small>
                                        サービス、プロダクトのUXについてレビュー評価しよう！
                                    </small>
                                    <a href="{{ url('/post/create') }}" class="mt-2 btn btn-outline-primary d-block">UXレビューする</a>
                                </div>
                            </div>

                            <div class="yy-outline mb-3">
                                <div class="yy-bg-test text-white px-3 py-2">
                                    <p class="m-0">
                                        依頼する
                                    </p>
                                </div>
                                <div class="px-3 py-2">
                                    <small>
                                        自分のサービス、プロダクトのレビューを依頼しよう！
                                    </small>
                                    <a href="{{ url('/request/create') }}" class="mt-2 btn btn-outline-primary d-block">UXレビュー依頼する</a>
                                </div>
                            </div>

                            <ul class="nav nav-pills flex-column mb-3">
                                <li class="nav-item yy-outline-bottom">
                                    <p class="nav-link yy-bg-test text-white my-0" >トップタグ</p>
                                </li>
                                @foreach($summaryTags as $tag)
                                <li class="nav-item yy-outline-bottom d-flex justify-content-between px-3 py-2">
                                    <a class="d-inline-block nav-link yy-bg-sidebar p-0" href="/timeline?tagId={{ $tag->tag_id }}">
                                        <span class="badge badge-pill badge-secondary">{{ $tag->tag_name }}</span>
                                    </a>
                                    <p class="d-inline-block m-0">{{ $tag->count }}<small>タグ</small></p>
                                </li>
                              @endforeach
                            </ul>

                            <ul class="nav nav-pills flex-column">
                                <li class="nav-item yy-outline-bottom">
                                    <p class="nav-link yy-bg-test text-white my-0" >
                                        今月のランキング
                                        <a class="text-white yy-fontsize-09" href="/ranking">
                                            (もっと見る)
                                        </a>
                                    </p>
                                </li>
                                @foreach($summaryScores as $score)
                                    <li class="nav-item yy-outline-bottom d-flex justify-content-between px-3 py-2">
                                        <a class="d-inline-block nav-link yy-bg-sidebar p-0" href="/{{ $score->user_name }}">
                                            <span class="yy-avatar-thumbnail-img" style="background-image: url({{ $score->avatar_image_path or '/images/app_images/yyuxlogo_black.png' }})"></span>
                                            <small>{{ $score->user_name }}</small>
                                        </a>
                                        <p class="d-inline-block m-0"><small>スコア</small>{{ $score->score }}</p>
                                    </li>
                                @endforeach
                            </ul>
                        </nav>
                    @show
                </div>
            </div>
            @include('subs.cropper')
        </div>

    </main>
    <!-- フッター -->
    <footer class="footer bg-dark">
    @section('footer')
        <div class="container">
            <div class="row justify-content-center bg-dark">
                <div class="col-12 m-0 p-0">
                    <div class="row mx-0 p-0 mt-3">
                        <div class="col-md-6 py-2 px-3">
                            <ul class="text-white">
                                <li>
                                    <a class="text-white" href="/legal">利用規約</a>
                                </li>
                                <li>
                                    <a class="text-white" href="/privacy">プライバシーボリシー</a>
                                </li>
                                <li>
                                    よくある質問
                                </li>
                                <li>
                                    <a class="text-white" href="/contact">お問い合わせ</a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-6 py-2 px-3 text-white d-flex align-items-center">
                            <div class="d-block">
                                <h1 class="pb-2">
                                    <img src="{{ asset('images/app_images/yyuxlogo_white.png') }}" style="height: 3.5rem;" class="mr-2" />
                                    yyUX
                                </h1>
                                <p class="d-inline">
                                    <a class="text-white" href="/about">yyUXについて</a>
                                </p>
                                <span class="px-1">|</span>
                                <p class="d-inline">
                                    <a class="text-white" href="http://yyux.hatenablog.com/" target="_blank">
                                        公式ブログ
                                    </a>
                                </p>
                                <span class="px-1">|</span>
                                <p class="d-inline">
                                    <a class="text-white" href="https://twitter.com/info_yyUX?lang=ja" target="_blank">
                                        <span class="fa fa-twitter"></span>@info_yyUX
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-12 py-2 px-3">
                    <p class="m-0 text-white text-center">
                        Copyright© 2017 yyUX All Rights Reserved.
                    </p>
                </div>
            </div>
        </div>
    @show
    </footer>
    <!-- Scripts -->
    @section('foot')
        <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js"></script>
        {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js"></script> --}}
        <script src="/js/app.js"></script>
        <script src="/js/myscripts.js"></script>
        <script>
            @if(Auth::user())
                // 通知アイコンをクリックで通知テーブルに既読をつける
                $('.yy-notifications-icon').on('click',function(){
                    var userId = {{Auth::user()->id}};
                    $.ajax({
                        url: "/notification/read",
                        type:'POST',
                        dataType: 'json',
                        data : {
                            userId : userId
                        },
                        success: function(data) {
                            $('.yy-unreadnotification-count').css('visibility', 'hidden');
                        },
                        error: function(XMLHttpRequest, textStatus, errorThrown){

                        }
                    });
                });
            @endif
        </script>
  @show
</body>
</html>

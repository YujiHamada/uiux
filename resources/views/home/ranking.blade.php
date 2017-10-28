@extends('layouts.app')

@section('content')
    <div class="col">

        <ul class="nav nav-pills flex-column">
            <li class="nav-item yy-outline-bottom">
                <p class="nav-link yy-bg-test text-white my-0" >
                    今月 ({{ date('n') }}月) のランキング
                </p>
            </li>
            @foreach($summaryScores as $score)
                <li class="nav-item yy-outline-bottom d-flex justify-content-between px-3 py-2">
                    <a class="d-inline-block nav-link yy-bg-sidebar p-0" href="/{{ $score->user_name }}">
                        <span class="yy-avatar-thumbnail-img yy-vertical-align-middle" style="background-image: url({{ $score->avatar_image_path or '/images/app_images/yyuxlogo_black.png' }})"></span>
                        <small>{{ $score->user_name }}</small>
                    </a>
                    <p class="d-inline-block m-0"><small>スコア</small>{{ $score->score }}</p>
                </li>
            @endforeach
        </ul>
    </div>

    <div class="col">

        <ul class="nav nav-pills flex-column">
            <li class="nav-item yy-outline-bottom">
                <p class="nav-link yy-bg-test text-white my-0" >
                    先月 ({{ date('n', strtotime('-1 month')) }}月) のランキング
                </p>
            </li>
            @foreach($lastMonthScores as $score)
                <li class="nav-item yy-outline-bottom d-flex justify-content-between px-3 py-2">
                    <a class="d-inline-block nav-link yy-bg-sidebar p-0" href="/{{ $score->name }}">
                        <span class="yy-avatar-thumbnail-img yy-vertical-align-middle" style="background-image: url({{ $score->avatar_image_path or '/images/app_images/yyuxlogo_black.png' }})"></span>
                        <small>{{ $score->name }}</small>
                    </a>
                    <p class="d-inline-block m-0"><small>スコア</small>{{ $score->user_score }}</p>
                </li>
            @endforeach
        </ul>
    </div>

@endsection

@section('rightSideBar')
@endsection

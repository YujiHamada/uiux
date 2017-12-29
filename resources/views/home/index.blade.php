@extends('layouts.app')

@section('content')
    <div class="col px-3">
        <div class="bg-warning text-white px-3 rounded mb-2">
            <p class="p-0 m-0">yyUXは現在β版として運用中です。</p>
        </div>
        @if(!Auth::user())
            <div class="bg-primary text-white px-3 rounded mb-2">
                <h1 class="pb-2 m-0">yyUXはUX(ユーザー体験)レビューサイトです！</h1>
                <p class="p-0 m-0">みんなでyy(ワイワイ)レビューして世の中のUXを良くしていきましょう！</p>
            </div>
        @endif

        @include('subs.flash-message-success')

        @if(!empty($searchWords))
            <h3>{{$searchWords}}の検索結果 {{$reviews->total()}}件</h3>
        @endif
        @if(!empty($selectedTag))
            <p>タグ>{{$selectedTag->name}}</p>
        @endif

        <!-- タブ -->
        <form action="" method="get">
            <input type="hidden" name="feed" value="">
            <input type="hidden" name="tagId" value="{{ $tagId or '' }}">
            <input type="hidden" name="searchWords" value="{{ $searchWords or '' }}">

            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <span class="yy-pointer nav-link {{ url()->current() === url('/') || app('request')->feed === 'ALL' || !isset(app('request')->feed) ? ' active' : '' }}" data-action="/timeline" data-feed="ALL">
                        All
                    </span>
                </li>
                <li class="nav-item">
                    <span class="yy-pointer nav-link {{ app('request')->feed === Config::get('enum.type.GOOD_UX') ? ' active' : '' }}" data-action="/timeline" data-feed="{{Config::get('enum.type.GOOD_UX')}}">Good UX</span>
                </li>
                <li class="nav-item">
                    <span class="yy-pointer nav-link {{ app('request')->feed === Config::get('enum.type.KAIZEN_UX') ? ' active' : '' }}" data-action="/timeline" data-feed="{{Config::get('enum.type.KAIZEN_UX')}}">KAIZEN UX</span>
                </li>
                <li class="nav-item">
                    <span class="yy-pointer nav-link {{ app('request')->feed === 'request' ? ' active' : '' }}" data-action="/timeline" data-feed="request">レビュー依頼</span>
                </li>
            </ul>
        </form>

        <div class="timeline pt-3">
            <!-- レビュー -->
            @foreach($reviews as $review)
                @include('subs.timelinereview')
            @endforeach

            <!-- ページネーション -->
            {!! $reviews->links('vendor.pagination.mypagination') !!}

        </div>

    </div>

@endsection
@section('foot')
    @parent
    <script>
        $('.yy-pointer').on('click', function() {
            //押されたボタンからフィードの種類（good or bad）の取得
            $('input[name="feed"]').val($(this).data('feed'));
            //値のないinputは削除（URLがごちゃごちゃするため）
            $('input[value=""]:not(input[name=searchWords])').remove();
            $(this).parents('form').attr('action', $(this).data('action'));
            $(this).parents('form').submit();
        });
    </script>
@endsection

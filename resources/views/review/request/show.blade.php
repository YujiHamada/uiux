@extends('layouts.app')

@section('head')
    @parent
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
    <div class="col mx-3 px-0">
        <div class="d-flex flex-row-reverse">
            {{-- 編集ボタン --}}
            @if(Auth::check())
                @if(Auth::user()->id == $review->user_id)
                    <a href="/request/edit/{{ $review->id }}">【編集】</a>
                @endif
            @endif
        </div>

        @include('subs.flash-message-success')

        <div class="p-3 yy-outline mb-3">
            <div class="yy-outline-bottom pb-3">

                <div class="row mx-0 d-flex justify-content-between mb-3">
                    <div class="col px-0">
                        <h1 class="m-0">{{ $review->title }}</h1>
                    </div>
                    <div>
                        @include('review.subs.review-type')
                    </div>
                </div>
                <div class="mt-1 d-flex justify-content-between my-2">
                    <div class="d-inline-block">
                        <p class="m-0 d-inline"><i class="far fa-comment-alt"></i> ： {{ $review->commentsCount()->count() }}</p>
                        <p class="m-0 d-inline ml-3"><i class="far fa-thumbs-up"></i> ： {{ $review->agreeCount()->count() }}</p>
                        <p class="m-0 d-inline ml-3"><i class="far fa-thumbs-down"></i> ： {{ $review->disagreeCount()->count() }}</p>
                    </div>
                    <div class="d-inline-block">
                        <span class="">{{ $review->page_view }} PV</span>
                    </div>
                </div>
                {{-- ユーザ情報 --}}
                @include('review.subs.show-review-user')
            </div>

            @if(Auth::check())
                <div class="py-3">
                    @include('review.subs.review-evaluation')
                </div>
            @endif

            {{-- 詳細 --}}
            <p>{!! nl2br($review->description) !!}</p>

            {{-- 編集ボタン --}}
            @if(Auth::check())
                @if(Auth::user()->id == $review->user_id)
                    <a href="/request/edit/{{ $review->id }}">【編集】</a>
                @endif
            @endif

            {{-- レビュー画像 --}}
            @include('review.subs.show-review-image')

            {{-- 参照URL --}}
            @include('review.subs.show-review-url')

            {{-- SNSシェアボタン --}}
            @include('review.subs.sns-share')

        </div>
        @include('review.subs.review-comment')

    </div>
@endsection

@section('foot')
    @parent
    <script>
        // ボタン連打対策
        $(function () {
            $('form').submit(function () {
                $(this).find(':submit').prop('disabled', true);
            });
        });

        // 賛成・反対のボタン押下時イベント。Ajax。
        $('.yy-review-evaluation').on('click',function(){
            var userId = {{ Auth::check() ? Auth::user()->id : ''}};
            var reviewId = {{$review->id}};
            var evaluation = $(this).val();
            $.ajax({
                url: "/review/evaluate",
                type:'POST',
                dataType: 'json',
                data : {
                    user_id : userId,
                    review_id : reviewId,
                    evaluation : evaluation
                },
                success: function(data) {
                    $('.yy-review-evaluation').toggleClass('yy-clicked');
                    if(data.isDeleted){
                        $('#yy-agree').text('レビューに賛成');
                        $('#yy-disagree').text('レビューに反対');
                    }else if(data.evaluation == {{Config::get('enum.evaluation.AGREE')}}){
                        $('#yy-agree').text('レビューに賛成済');
                    }else if(data.evaluation == {{Config::get('enum.evaluation.DISAGREE')}}){
                        $('#yy-disagree').text('レビューに反対済');
                    }
                },
                error: function(XMLHttpRequest, textStatus, errorThrown){
                    alert('賛成・反対の送信に失敗しました');
                }
            });
        });

        $('.yy-comment-evaluation').on('click',function(){
            var userId = $(this).data('comment-user-id');
            var reviewId = $(this).data('comment-review-id');
            var commentId = $(this).data('comment-id');
            var evaluation = $(this).val();
            $.ajax({
                url: "/review/comment/evaluate",
                type:'POST',
                dataType: 'json',
                data : {
                    user_id : userId,
                    review_id : reviewId,
                    comment_id : commentId,
                    evaluation : evaluation
                },
                success: function(data) {
                    $('#yy-comment-agree-' + data.commentId).toggleClass('yy-clicked');
                    $('#yy-comment-disagree-' + data.commentId).toggleClass('yy-clicked');
                    if(data.isDeleted){
                        $('#yy-comment-agree-' + data.commentId).text('イイネ');
                        $('#yy-comment-disagree-' + data.commentId).text('ワルイネ');
                    }else if(data.evaluation == {{Config::get('enum.evaluation.AGREE')}}){
                        $('#yy-comment-agree-' + data.commentId).text('イイネ済');
                    }else if(data.evaluation == {{Config::get('enum.evaluation.DISAGREE')}}){
                        $('#yy-comment-disagree-' + data.commentId).text('ワルイネ済');
                    }
                },
                error: function(XMLHttpRequest, textStatus, errorThrown){
                    alert('賛成・反対の送信に失敗しました');
                }
            });
        });
    </script>
@endsection

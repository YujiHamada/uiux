@extends('layouts.app')

@section('head')
  @parent
  <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
  <div class="col mx-3 px-0">

    @include('subs.flash-message-success')

    <div class="p-3 yy-outline mb-3">
      <div class="yy-outline-bottom pb-3">

        <div class="row mx-0 d-flex justify-content-between mb-3">
          <div class="col px-0">
            <h3 class="m-0">{{ $review->title }}</h3>
          </div>
          <div>
            @include('review.subs.review-type')
          </div>
        </div>
        <div class="mt-1">
          <p class="m-0 d-inline"><i class="fa fa-commenting-o" aria-hidden="true"></i> ： {{ $review->commentsCount()->count() }}</p>
          <p class="m-0 d-inline ml-3"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> ： {{ $review->agreeCount()->count() }}</p>
          <p class="m-0 d-inline ml-3"><i class="fa fa-thumbs-o-down" aria-hidden="true"></i> ： {{ $review->disagreeCount()->count() }}</p>
        </div>
        <div class="row mx-0">
          <div class="col p-0">
            <span class="yy-avatar-thumbnail-img yy-vertical-align-middle" style="background-image: url({{ $review->user->avatar_image_path or '/images/app_images/yyuxlogo_black.png' }})"></span>
            @if(isset($review->user))
              <a class="yy-fontsize-09" href="{{ action('UserController@show', ['username' => $review->user->name or '退会済みユーザー']) }}" title="">{{ $review->user->name }}</a>
            @else
              <span class ="yy-fontsize-09">{{ '退会済みユーザー' }}</span>
            @endif
            @foreach($review->reviewTag as $reviewTag)
              <a href="/timeline?tagId={{ $reviewTag->tag->id }}"><span class="badge badge-pill badge-default">{{ $reviewTag->tag->name }}</span></a>
            @endforeach
          </div>
          <div class="col-3 p-0 text-right">
            <p class="text-right m-0 yy-fontsize-09">{{\App\Libs\Util::agoDateWriting($review->created_at)}}</p>
          </div>
        </div>
      </div>

      <div class="">
        <div class="py-3">
          @include('review.subs.review-evaluation')
        </div>

        <p>{{ $review->description }}</p>

        @if($review->image_name)
          <div class="col-3 p-0">
            <span class="yy-review-img d-block" style="background-image: url({{ asset(Config::get('const.IMAGE_FILE_DIRECTORY') . $review->image_name) }})"></span>
          </div>
        @endif

        @if(Auth::user()->id == $review->user_id)
          <a href="/post/edit/{{ $review->id }}">【編集】</a>
        @endif

      </div>
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
      var userId = {{Auth::user()->id}};
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
      var commentId = $(this).data('comment-id');
      var evaluation = $(this).val();
      $.ajax({
        url: "/review/comment/evaluate",
        type:'POST',
        dataType: 'json',
        data : {
          user_id : userId,
          comment_id : commentId,
          evaluation : evaluation,
          reviewId : {{$review->id}}
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
          alert('イイね・ワルイねの送信に失敗しました');
        }
      });
    });

  </script>
@endsection

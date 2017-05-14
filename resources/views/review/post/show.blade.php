@extends('layouts.app')

@section('head')
  @parent
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <style>
      img {
        width: auto;
        height: auto;
        max-width: 120px;
        max-height: 150px;
      }
      .clicked{
        /*bootstrapのdisabledとほぼ同じだけどカーソルにnot-allowedをつけたくないのでここに書きました*/
        filter: alpha(opacity=65);
        -webkit-box-shadow: none;
        box-shadow: none;
        opacity: .65;
      }
  </style>
@endsection

@section('content')
  <div class="col mx-3">

    @include('subs.flash-message-success')

    @if($review->image_name)
     <img src="{{ asset(Config::get('const.IMAGE_FILE_DIRECTORY') . $review->image_name) }}" alt="">
    @endif
    <h4>タイトル：{{ $review->title }}</h4>
    <p>詳細：{{ $review->description }}</p>
    <span>{{\App\Libs\Util::agoDateWriting($review->created_at)}}</span>

    @if(Auth::user()->id != $review->user_id)
      <p>
      賛成数：{{$review->agreeCount()->count()}}
      反対数：{{$review->disagreeCount()->count()}}
      </p>
      <p>↓このレビューに↓</p>
      <button id="yy-agree" class="yy-review-evaluation btn btn-primary {{ isset($evaluation) ? ' clicked' : '' }}" type="button" value="{{Config::get('enum.evaluation.AGREE')}}">
        {{ (isset($evaluation) && $evaluation->is_agree == 1) ? '賛成済' : '賛成' }}
      </button>
      <button id="yy-disagree" class="yy-review-evaluation btn btn-warning {{isset($evaluation) ? ' clicked' : ''}}" type="button" value="{{Config::get('enum.evaluation.DISAGREE')}}">
        {{ (isset($evaluation) && $evaluation->is_agree == 0) ? '反対済' : '反対' }}
      </button>

    @endif

    @if(Auth::user()->id == $review->user_id)
      <a href="/post/edit/{{$review->id}}">【編集】</a>
    @endif


    @foreach($review->reviewTag as $reviewTag)
      <span class="badge badge-pill badge-default">{{ $reviewTag->tag->name }}</span>
    @endforeach

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
        $('.yy-review-evaluation').toggleClass('clicked');
        if(data.isDeleted){
          $('#yy-agree').text('賛成');
          $('#yy-disagree').text('反対');
        }else if(data.evaluation == {{Config::get('enum.evaluation.AGREE')}}){
          $('#yy-agree').text('賛成済');
        }else if(data.evaluation == {{Config::get('enum.evaluation.DISAGREE')}}){
          $('#yy-disagree').text('反対済');
        }
      },
      error: function(XMLHttpRequest, textStatus, errorThrown){
        alert('賛成・反対の送信に失敗しました');
      }
    });
  });

  $('.yy-comment-evaluation').on('click',function(){
    var userID = {{Auth::user()->id}};
    var commentId = $(this).data('comment-id');
    var evaluation = $(this).val();
    $.ajax({
      url: "/review/comment/evaluate",
      type:'POST',
      dataType: 'json',
      data : {
        user_id : userId,
        comment_id : commentId,
        evaluation : evaluation
        },
      success: function(data) {
        console.log('#yy-comment-agree-' + data.commentId);
        $('#yy-comment-agree-' + data.commentId).toggleClass('clicked');
        $('#yy-comment-disagree-' + data.commentId).toggleClass('clicked');
        if(data.isDeleted){
          $('#yy-comment-agree-' + data.commentId).text('賛成');
          $('#yy-comment-disagree-' + data.commentId).text('反対');
        }else if(data.evaluation == {{Config::get('enum.evaluation.AGREE')}}){
          $('#yy-comment-agree-' + data.commentId).text('賛成済');
        }else if(data.evaluation == {{Config::get('enum.evaluation.DISAGREE')}}){
          $('#yy-comment-disagree-' + data.commentId).text('反対済');
        }
      },
      error: function(XMLHttpRequest, textStatus, errorThrown){
        alert('賛成・反対の送信に失敗しました');
      }
    });
  });
  </script>
@endsection

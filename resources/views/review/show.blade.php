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
    @if (session('flash_message'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        {{ session('flash_message') }}
      </div>
    @endif
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
    @else
      <a href="/review/edit/{{$review->id}}">【編集】</a>
    @endif
    @foreach($review->reviewTag as $reviewTag)
      <span class="badge badge-pill badge-default">{{ $reviewTag->tag->name }}</span>
    @endforeach

    <div class="comments">
      <h5 class="comment-header">コメント：{{$review->commentsCount()->count()}}件</h5>
      @foreach($review->comments as $reviewComment)
        <div class="comment">
          <div>
            <p>{{$reviewComment->comment}}</p>
          </div>
          <div class="commented-user">
            @if($reviewComment->user->id == Auth::user()->id)
              <form action="{{ action('ReviewCommentController@destroy') }}" method="post" accept-charset="utf-8">
                {{ csrf_field() }}
                <input type="hidden" name="commentId" value="{{$reviewComment->id}}">
                <input type="hidden" name="reviewId" value="{{$review->id}}">
                <input class="btn btn-danger btn-sm" type="submit" name="deleteButton" value="削除">
              </form>
            @else
              <button id="yy-comment-agree-{{$reviewComment->id}}" class="yy-comment-evaluation btn btn-primary btn-sm {{ isset($reviewComment->evaluation) ? ' clicked' : '' }}" type="button" value="{{Config::get('enum.evaluation.AGREE')}}" data-comment-id="{{$reviewComment->id}}">
                {{ (isset($reviewComment->evaluation) && $reviewComment->evaluation->is_agree == 1) ? '賛成済' : '賛成' }}
              </button>
              <button id="yy-comment-disagree-{{$reviewComment->id}}" class="yy-comment-evaluation btn btn-warning btn-sm {{isset($reviewComment->evaluation) ? ' clicked' : ''}}" type="button" value="{{Config::get('enum.evaluation.DISAGREE')}}" data-comment-id="{{$reviewComment->id}}">
                {{ (isset($reviewComment->evaluation) && $reviewComment->evaluation->is_agree == 0) ? '反対済' : '反対' }}
              </button>
            @endif
            賛成数：{{$reviewComment->agreeCount()->count()}}
            反対数：{{$reviewComment->disagreeCount()->count()}}
            <span>投稿者：{{$reviewComment->user->name}}</span>
            <span>投稿時間：{{\App\Libs\Util::agoDateWriting($reviewComment->created_at)}}</span>
          </div>
        </div>
      @endforeach
    </div>

    <p>このレビューにコメントをする</p>
    @if ($errors->has('comment'))
      <span class="help-block">
        <strong>{{ $errors->first('comment') }}</strong>
      </span>
    @endif
    <form action="{{ action('ReviewCommentController@store') }}" method="post">
      {{ csrf_field() }}
      <textarea class="comment-textarea" name="comment"></textarea>
      <input type="hidden" name="reviewId" value="{{$review->id}}">
      <input type="hidden" name="userId" value="{{Auth::user()->id}}">
      <input class="btn btn-primary" type="submit" name="commentSubmit" value="コメントする">
    </form>
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
    var userID = {{Auth::user()->id}};
    var reviewID = {{$review->id}};
    var evaluation = $(this).val();
    $.ajax({
      url: "/review/evaluate",
      type:'POST',
      dataType: 'json',
      data : {
        user_id : userID,
        review_id : reviewID,
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
        user_id : userID,
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

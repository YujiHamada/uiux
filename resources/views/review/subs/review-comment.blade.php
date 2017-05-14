<div class="comments">
  <h5 class="comment-header">コメント：{{$review->commentsCount()->count()}}件</h5>
  @foreach($review->comments as $reviewComment)
    <div class="comment">
      <div>
        <p>{{$reviewComment->comment}}</p>
      </div>
      <div class="commented-user">
        @if($reviewComment->user->id == Auth::user()->id)
          <form action="{{ action('ReviewController@destroyComment') }}" method="post" accept-charset="utf-8">
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

  <p>このレビューにコメントをする</p>
  @if ($errors->has('comment'))
    <span class="help-block">
      <strong>{{ $errors->first('comment') }}</strong>
    </span>
  @endif
  <form action="{{ action('ReviewController@storeComment') }}" method="post">
    {{ csrf_field() }}
    <textarea class="comment-textarea" name="comment"></textarea>
    <input type="hidden" name="reviewId" value="{{$review->id}}">
    <input type="hidden" name="userId" value="{{Auth::user()->id}}">
    <input class="btn btn-primary" type="submit" name="commentSubmit" value="コメントする">
  </form>
</div>

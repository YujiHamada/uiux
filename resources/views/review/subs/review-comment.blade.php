<div class="">
  <div class="p-3">
    <h6 class="yy-outline-bottom m-0">コメント：{{$review->commentsCount()->count()}}件</h6>
    @foreach($review->comments as $reviewComment)
      <div class="yy-outline-bottom py-2">
        <div>
          <p>{{$reviewComment->comment}}</p>
        </div>
        <div class="py-2">
          @if($reviewComment->user->id == Auth::user()->id)
            <form action="{{ action('ReviewController@deleteComment') }}" method="post" accept-charset="utf-8" class="d-inline">
              {{ csrf_field() }}
              <input type="hidden" name="commentId" value="{{$reviewComment->id}}">
              <input type="hidden" name="reviewId" value="{{$review->id}}">
              <input class="btn btn-warning btn-sm" type="submit" name="deleteButton" value="コメント削除">
            </form>
          @else
            <button id="yy-comment-agree-{{$reviewComment->id}}"
              class="yy-comment-evaluation btn btn-primary btn-sm {{ isset($reviewComment->evaluation) ? ' yy-clicked' : '' }}"
              type="button" value="{{Config::get('enum.evaluation.AGREE')}}" data-comment-id="{{$reviewComment->id}}">
              {{ (isset($reviewComment->evaluation) && $reviewComment->evaluation->is_agree == 1) ? 'イイネ済' : 'イイネ' }}
            </button>
            <button id="yy-comment-disagree-{{$reviewComment->id}}"
              class="yy-comment-evaluation btn btn-danger btn-sm {{isset($reviewComment->evaluation) ? ' yy-clicked' : ''}}"
              type="button" value="{{Config::get('enum.evaluation.DISAGREE')}}" data-comment-id="{{$reviewComment->id}}">
              {{ (isset($reviewComment->evaluation) && $reviewComment->evaluation->is_agree == 0) ? 'ワルイネ済' : 'ワルイネ' }}
            </button>
          @endif
          <p class="m-0 d-inline ml-3"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> ： {{ $reviewComment->agreeCount()->count() }}</p>
          <p class="m-0 d-inline ml-3"><i class="fa fa-thumbs-o-down" aria-hidden="true"></i> ： {{ $reviewComment->disagreeCount()->count() }}</p>
        </div>
        <div class="d-flex justify-content-between">
          <div class="d-inline-block">
            <span class="yy-avatar-thumbnail-img yy-vertical-align-middle" style="background-image: url({{ asset($reviewComment->user->avatar_image_path) }})"></span>
            <a class ="yy-fontsize-09" href="{{ action('UserController@show', ['username' => $reviewComment->user->name]) }}" title="">{{ $reviewComment->user->name }}</a>
          </div>
          <span>投稿時間：{{\App\Libs\Util::agoDateWriting($reviewComment->created_at)}}</span>
        </div>

      </div>
    @endforeach
  </div>

  <div class="p-3">
    <p>このレビューにコメントをする</p>
    @if ($errors->has('comment'))
      <span class="help-block">
        <strong>{{ $errors->first('comment') }}</strong>
      </span>
    @endif
    <form action="{{ action('ReviewController@storeComment') }}" method="post">
      {{ csrf_field() }}
      <textarea class="w-100" name="comment"></textarea>
      <input type="hidden" name="reviewId" value="{{$review->id}}">
      <input type="hidden" name="userId" value="{{Auth::user()->id}}">
      <input class="btn btn-primary" type="submit" name="commentSubmit" value="コメントする">
    </form>
  </div>

</div>

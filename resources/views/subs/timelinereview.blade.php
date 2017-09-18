<div class="mb-3 p-3 yy-bg-white yy-outline">

  <div class="row mx-0">

    <div class="col-9 p-0 d-flex flex-column">
      <div class="d-flex justify-content-between mb-2">
        <a class="yy-overflow-hidden" href="{{ !empty($review->is_request) ? '/request/' : '/post/' }}{{ $review->id }}">
          <h5 class="yy-word-wrap m-0">{{ $review->title }}</h5>
        </a>
        @include('review.subs.review-type')
      </div>

      <p class="yy-review-word-wrap text-justify m-0 mb-auto">{{ $review->description }}</p>

      <div class="mt-1">
        <p class="m-0 d-inline"><i class="fa fa-commenting-o" aria-hidden="true"></i> ： {{ $review->commentsCount()->count() }}</p>
        <p class="m-0 d-inline ml-3"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> ： {{ $review->agreeCount()->count() }}</p>
        <p class="m-0 d-inline ml-3"><i class="fa fa-thumbs-o-down" aria-hidden="true"></i> ： {{ $review->disagreeCount()->count() }}</p>
      </div>
    </div>
    @if($review->image_name)
      <div class="col-3 p-0">
        <span class="yy-review-img d-block ml-auto" style="background-image: url({{ asset(Config::get('const.IMAGE_FILE_DIRECTORY') . $review->image_name) }})"></span>
      </div>
    @else
      <div class="col-3 p-0">
        <span class="yy-review-img d-block ml-auto yy-bg-powderblue" style="background-image: url({{ asset(Config::get('const.APP_IMAGES_DIRECTORY') . 'yyuxlogo_white.png') }})"></span>
      </div>
    @endif
  </div>
  <div class="row mx-0">
    <div class="col p-0">
      <span class="yy-avatar-thumbnail-img yy-vertical-align-middle" style="background-image: url({{ $review->user->avatar_image_path or '/images/app_images/yyuxlogo_black.png' }})"></span>
      @if(isset($review->user))
        <a class="yy-fontsize-09" href="{{ action('UserController@show', ['username' => isset($review->user->name) ? $review->user->name : '退会済みユーザー']) }}" title="">{{ $review->user->name }}</a>
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

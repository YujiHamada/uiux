<div class="mb-3 p-3 yy-bg-white yy-outline">

  <div class="row mx-0">
    {{-- <div class="col-sm-2 px-0">
      <p class="m-0 mb-2"><i class="fa fa-commenting-o" aria-hidden="true"></i> ： {{ $review->commentsCount()->count() }}</p>
      <p class="m-0 mb-2"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> ： {{ $review->agreeCount()->count() }}</p>
      <p class="m-0 mb-2"><i class="fa fa-thumbs-o-down" aria-hidden="true"></i> ： {{ $review->disagreeCount()->count() }}</p>
    </div> --}}

    <div class="col-9 p-0">
      <div class="d-flex justify-content-between">
        <a class="yy-overflow-hidden" href="{{ action('ReviewController@show', $review->id) }}">
          <h5 class="yy-word-wrap mb-1">{{ $review->title }}</h5>
        </a>
        @if(Config::get('enum.good_or_bad.GOOD') == $review->good_or_bad)
          <span class="badge badge-success mb-1" style="vertical-align: middle;">GOOD!!</span>
        @elseif(Config::get('enum.good_or_bad.BAD') == $review->good_or_bad)
          <span class="badge badge-danger mb-1">BAD</span>
        @elseif(Config::get('enum.good_or_bad.SOSO') == $review->good_or_bad)
          {{-- <p><span class="badge badge-default">SOSO</span></p> --}}
        @endif
      </div>

      <p class="yy-review-word-wrap text-justify m-0">{{ $review->description }}.
        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.
        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.
        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.
        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.
      </p>

      <div class="mt-1">
        <p class="m-0 d-inline"><i class="fa fa-commenting-o" aria-hidden="true"></i> ： {{ $review->commentsCount()->count() }}</p>
        <p class="m-0 d-inline ml-3"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> ： {{ $review->agreeCount()->count() }}</p>
        <p class="m-0 d-inline ml-3"><i class="fa fa-thumbs-o-down" aria-hidden="true"></i> ： {{ $review->disagreeCount()->count() }}</p>
      </div>
    </div>
    @if($review->image_name)
      <div class="col-3 p-0 text-right">
        <span class="yy-review-img d-block ml-auto" style="background-image: url({{ asset(Config::get('const.IMAGE_FILE_DIRECTORY') . $review->image_name) }})"></span>
      </div>
    @endif
  </div>
  <div class="row mx-0">
    <div class="col p-0">
      <span class="yy-avatar-thumbnail-img yy-vertical-align-middle" style="background-image: url({{ asset($review->user->avatar_image_path) }})"></span>
      <a class ="yy-fontsize-09" href="{{ action('UserController@show', ['username' => $review->user->name]) }}" title="">{{ $review->user->name }}</a>
      @foreach($review->reviewCategory as $reviewCategory)
        <a href="/timeline?categoryId={{ $reviewCategory->category->id }}"><span class="badge badge-pill badge-default">{{ $reviewCategory->category->name }}</span></a>
      @endforeach
    </div>
    <div class="col-3 p-0 text-right">
      <p class="text-right m-0 yy-fontsize-09">{{\App\Libs\Util::agoDateWriting($review->created_at)}}</p>
    </div>
  </div>

</div>

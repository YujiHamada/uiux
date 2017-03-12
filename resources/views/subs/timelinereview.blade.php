<div class="row review">

  <div class="col-3">
    @if(Config::get('enum.good_or_bad.GOOD') == $review->good_or_bad)
      <p><span class="badge badge-success">GOOD!!</span></p>
    @elseif(Config::get('enum.good_or_bad.BAD') == $review->good_or_bad)
      <p><span class="badge badge-danger">BAD</span></p>
    @elseif(Config::get('enum.good_or_bad.SOSO') == $review->good_or_bad)
      <p><span class="badge badge-default">SOSO</span></p>
    @endif
    <p>コメント数：{{$review->commentsCount()->count()}}</p>
    <p>賛成数：{{$review->agreeCount()->count()}}</p>
    <p>反対数：{{$review->disagreeCount()->count()}}</p>
  </div>

  <div class="col">
    <a href="{{ action('ReviewController@show', $review->id) }}"><h5>{{$review->title}}</h5></a>
    <p>{{$review->description}}</p>
    @foreach($review->reviewCategory as $reviewCategory)
      <span class="badge badge-pill badge-default">{{$reviewCategory->category->name}}</span>
    @endforeach
    <p>{{\App\Libs\Util::agoDateWriting($review->created_at)}}</p>
  </div>

  <div class="col-2">
  @if($review->image_name)
    <img class="media-object" src="{{ asset(Config::get('const.IMAGE_FILE_DIRECTORY') . $review->image_name) }}" alt="がぞう">
  @endif
    <a href="{{ action('UserController@show', ['username' => $review->user->name]) }}" title="">{{$review->user->name}}</a>
  </div>
  
</div>

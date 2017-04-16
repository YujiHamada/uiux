@extends('layouts.user')

@section('head')
  @parent
  <style>
  img {
      width: auto;
      height: auto;
      max-width: 120px;
      max-height: 150px;
  }
  div.review{
    border-top: 1px solid #ddd;
  }
  </style>
@endsection

@section('content')
  <div class="col mx-3">
    <h4>タイムライン</h4>
    <div class="timeline">
    	@foreach($reviews as $review)
        <div class="row review">
          <div class="col-3">
            @if(Config::get('enum.good_or_bad.GOOD') == $review->good_or_bad)
              <p><span class="badge badge-success">GOOD!!</span></p>
            @elseif(Config::get('enum.good_or_bad.BAD') == $review->good_or_bad)
              <p><span class="badge badge-danger">BAD</span></p>
            @elseif(Config::get('enum.good_or_bad.SOSO') == $review->good_or_bad)
              <p><span class="badge badge-default">SOSO</span></p>
            @endif
            <p>コメント数：</p>
            <p>賛成数：{{$review->agreeCount()->count()}}</p>
            <p>反対数：{{$review->disagreeCount()->count()}}</p>
          </div>
          <div class="col">
            <a href="{{ action('ReviewController@show', $review->id) }}"><h5>{{$review->title}}</h5></a>
            <p>{{$review->description}}</p>
            @foreach($review->reviewTag as $reviewTag)
              <span class="badge badge-pill badge-default">{{$reviewTag->tag->name}}</span>
            @endforeach
          </div>
          <div class="col-2">
          @if($review->image_name)
            <img class="media-object" src="{{ asset(Config::get('const.IMAGE_FILE_DIRECTORY') . $review->image_name) }}" alt="がぞう">
          @endif
            <a href="{{ action('UserController@show', ['username' => $review->user->name]) }}" title="">{{$review->user->name}}</a>
          </div>
        </div>
      @endforeach
    </div>
  </div>
@endsection

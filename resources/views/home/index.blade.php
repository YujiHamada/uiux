@extends('layouts.app')

@section('css')
  <style>
    img {
        width: auto;
        height: auto;
        max-width: 120px;
        max-height: 150px;
    }
  </style>
@endsection

@section('content')
  @if (session('flash_message'))
      <div class="flash_message" onClick="this.classList.add('hidden')">
          {{ session('flash_message') }}
      </div>
  @endif
  <div class="panel panel-default">
    <div class="panel-heading">
      <a href="{{ url('/review/create') }}">UIUXレビューを投稿する</a>
    </div>
  </div>
  <div class="timeline">
  	@foreach($reviews as $review)
      <div class="media">
        <a class="media-left" href="{{ action('ReviewController@show', $review->id) }}">
  		    <img class="media-object" src="{{Config::get('const.IMAGE_FILE_DIRECTORY')}}{{ $review->image_name }}" alt="がぞう">
        </a>
  		  <div class="media-body">
          <h4 class="media-heading">{{ $review->title }}</h4>
          <p>{{ $review->description }}</p>
        </div>
      </div>
    @endforeach
  </div>
@endsection

@section('js')
  <script>
  </script>
@endsection

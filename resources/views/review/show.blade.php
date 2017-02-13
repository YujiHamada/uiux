@extends('layouts.app')

@section('head')
  @parent
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
  <img src="/{{Config::get('const.IMAGE_FILE_DIRECTORY')}}{{$review->image_name }}" alt="">
  <h4>タイトル：{{ $review->title }}</h4>
  <p>詳細：{{ $review->description }}</p>
@endsection

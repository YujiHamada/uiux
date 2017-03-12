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
    div.review{
      border-top: 1px solid #ddd;
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

    <div class="panel panel-default">
      <div class="panel-heading">
        <a href="{{ url('/review/create') }}">UIUXレビューを投稿する</a>
      </div>
    </div>


    <div class="timeline">

      <!-- タブ -->
      <ul class="nav nav-tabs">
        <li class="nav-item">
          <a class="nav-link {{ url()->current() === url('/') || url()->current() === url('/timeline/all') ? " active" : "" }}" href="/timeline/all">All</a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ url()->current() === url('/timeline/good') ? " active" : "" }}" href="/timeline/good">Good</a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ url()->current() === url('/timeline/bad') ? " active" : "" }}" href="/timeline/bad">Bad</a>
        </li>
      </ul>

      <!-- レビュー -->
      @foreach($reviews as $review)
        @include('subs.timelinereview')
      @endforeach

      <!-- ページネーション -->
      {!! $reviews->links('vendor.pagination.mypagination') !!}

    </div>

  </div>

@endsection

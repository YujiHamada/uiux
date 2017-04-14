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
    <div class="timeline pt-3">
      <!-- レビュー -->
      @foreach($reviews as $review)
        @include('subs.timelinereview')
      @endforeach

      <!-- ページネーション -->
      {!! $reviews->links('vendor.pagination.mypagination') !!}

    </div>
  </div>
@endsection

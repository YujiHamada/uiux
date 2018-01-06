@extends('layouts.user')

@section('content')
  <div class="col-12 col-lg-8 px-3">

    <h4 class="my-3">タイムライン</h4>

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

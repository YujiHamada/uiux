@extends('layouts.app')

@section('content')
  <div class="col mx-3 px-0">

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
    @if(!empty($serchWords))
      <h3>{{$serchWords}}の検索結果 {{$reviews->total()}}件</h3>
    @endif
    @if(!empty($selectedCategory))
      <p>カテゴリー>{{$selectedCategory->name}}</p>
    @endif

    <!-- タブ -->
    <form action="" method="get">
      <input type="hidden" name="feed" value="">
      <input type="hidden" name="categoryId" value="{{ $categoryId or '' }}">
      <input type="hidden" name="serchWords" value="{{ $serchWords or '' }}">
    
      <ul class="nav nav-tabs">
        <li class="nav-item">
          <span class="yy-review-kind nav-link {{ url()->current() === url('/') || app('request')->feed === 'ALL' || empty(app('request')->feed) ? ' active' : '' }}" data-action="/timeline" data-feed="ALL">
            All
          </span>
        </li>
        <li class="nav-item">
          <span class="yy-review-kind nav-link {{ app('request')->feed === 'GOOD' ? ' active' : '' }}" data-action="/timeline" data-feed="GOOD">Good</span>
        </li>
        <li class="nav-item">
          <span class="yy-review-kind nav-link {{ app('request')->feed === 'BAD' ? ' active' : '' }}" data-action="/timeline" data-feed="BAD">Bad</span>
        </li>
      </ul>
    </form>

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
@section('foot')
  @parent
  <script>

    $('.yy-review-kind').on('click', function() {
      //押されたボタンからフィードの種類（good or bad）の取得
      $('input[name="feed"]').val($(this).data('feed'));
      //値のないinputは削除（URLがごちゃごちゃするため）
      $('input[value=""]').remove();
      $(this).parents('form').attr('action', $(this).data('action'));
      $(this).parents('form').submit();
    });

  </script>


@endsection

@extends('layouts.user')

@section('css')
  <style>
    img {
      width: auto;
      height: auto;
      max-width: 150px;
      max-height: 150px;
    }
  </style>
@endsection

@section('content')
    <h4>タイムライン</h4>
    @forelse ($reviews as $review)
    <div class="col-sm-6 col-xs-12">

      <div class="media">
        <div class="media-body">
          <h4 class="media-heading">{{ $review->title }}</h4>
          <p>{{ $review->description }}</p>
        </div>
      </div>
      <div id="carousel-example-generic{{ $review->id }}" class="carousel slide" data-interval="false">
        <!-- Indicators -->
        <ol class="carousel-indicators">
          <li data-target="#carousel-example-generic{{ $review->id }}" data-slide-to="0" class="active"></li>
          <li data-target="#carousel-example-generic{{ $review->id }}" data-slide-to="1"></li>
        </ol>

        <!-- Wrapper for slides -->
        <div class="carousel-inner" role="listbox">
          <div class="item active">
            <img src="{{Config::get('const.IMAGE_FILE_DIRECTORY')}}{{ $review->image_name }}" alt="..." style="display: inline-block; mergin: 0px auto;">
            <div class="carousel-caption">
              ...
            </div>
          </div>
          <div class="item">
            <img src="{{Config::get('const.IMAGE_FILE_DIRECTORY')}}{{ $review->image_name }}" alt="..." style="mergin: 0px auto;">
            <div class="carousel-caption">
              ...
            </div>
          </div>
          ...
        </div>

        <!-- Controls -->
        <a class="left carousel-control" href="#carousel-example-generic{{ $review->id }}" role="button" data-slide="prev">
          <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" href="#carousel-example-generic{{ $review->id }}" role="button" data-slide="next">
          <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
      </div>
    </div>
    @empty
        <p>
          投稿したレビューはありません。
        </p>
    @endforelse

@endsection

@section('js')
<scrit>
</script>
@endsection

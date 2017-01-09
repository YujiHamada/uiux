@extends('layouts.user')

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
  <h4>ユーザネーム：{{ $user->name }}</h4>
  @forelse ($reviews as $review)
      <div class="media">
        <a class="media-left" href="{{ action('ReviewController@show', $review->id) }}">
          <img class="media-object" src="{{Config::get('const.IMAGE_FILE_DIRECTORY')}}{{ $review->image_name }}" alt="がぞう">
        </a>
        <div class="media-body">
          <h4 class="media-heading">{{ $review->title }}</h4>
          <p>{{ $review->description }}</p>
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

@extends('layouts.app')

@section('content')
  <div class="col mx-3">
    @if(isset($review))
      <a href="/review/delete/{{ $review->id }}" onclick="return deleteConfirm();">このレビューを削除</a>｜
    @endif

    <h1>レビュー依頼する</h1>
    <form class="form-horizontal" role="form" method="POST" action="{{ url('/request/store') }}" enctype="multipart/form-data">
    	{{ csrf_field() }}
    	タイトル：
      <input id="title" type="text" class="form-control" name="title" value="{{ old('title', isset($review->title) ? $review->title : '') }}" required autofocus>
    	詳細：
      @if ($errors->has('title'))
        <span class="help-block">
          <strong>{{ $errors->first('title') }}</strong>
        </span>
      @endif
      <textarea id="description" type="text" class="form-control" name="description">{{ old('description', isset($review->description) ? $review->description : '') }}</textarea>
      @if ($errors->has('description'))
        <span class="help-block">
            <strong>{{ $errors->first('description') }}</strong>
        </span>
      @endif
      URL：
      <input id="url" type="text" class="form-control" name="url" value="{{ old('url', isset($review->url) ? $review->url : '') }}">
      @if ($errors->has('url'))
        <span class="help-block">
            <strong>{{ $errors->first('url') }}</strong>
        </span>
      @endif
      タグ：
      @include('review.subs.review-tag')

      <input type="file" name="uiImage" value="{{ old('uiImage') }}">
      <button type="submit" class="btn btn-primary">投稿</button>
    </form>
    <div class="preview">
    </div>
  </div>
@endsection

@section('foot')
  @parent

  @include('review.js.autocomplete-tag-form')
  @include('review.js.enter-tag-form')
  @include('review.js.remove-tag')
  @include('review.js.input-tag')
  @include('review.js.delete-review-confirm')

@endsection

@extends('layouts.app')

@section('content')
  <div class="col mx-3">
    @if(isset($review))
      <a href="/review/delete/{{ $review->id }}" onclick="return deleteConfirm();">このレビューを削除</a>｜
      <a href="/post/report/kaizen/{{ $review->id }}">このUXが改善されたことを報告する</a>
    @endif
    <h1>レビューする</h1>
    <form class="form-horizontal" role="form" method="POST" action="{{ url('/post/store') }}" enctype="multipart/form-data">
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
      <div class="tags">
        <input type="text" id="tag">
        @if(isset($review))
          @foreach($review->reviewTag as $reviewTag)
            <span class="badge badge-pill badge-default">{{ $reviewTag->tag->name }}</span>
            <input name="review_tag_names[]" type="hidden" value="{{ $reviewTag->tag->name }}">
          @endforeach
        @endif
      </div>
      @if ($errors->has('tags'))
        <span class="help-block">
            <strong>{{ $errors->first('tags') }}</strong>
        </span>
      @endif

      <label class="radio-inline">
        <input type="radio" name="type" value="{{ Config::get('enum.type.GOOD_UX') }}"
          @if(isset($review->type))
            @if(old('type', isset($review->type) ? $review->type : '') == Config::get('enum.type.GOOD_UX'))
               checked
            @endif
          @else
            {{-- 作成初期段階ではGood UXを初期選択しておく --}}
             checked
          @endif>
          Good UX
      </label>
      <label class="radio-inline">
        <input type="radio" name="type" value="{{ Config::get('enum.type.KAIZEN_UX') }}"
          @if(old('type', isset($review->type) ? $review->type : '') == Config::get('enum.type.KAIZEN_UX'))
             checked
          @endif>
          KAIZEN UX
      </label>
      <label class="radio-inline">
        <input type="radio" name="type" value="{{ Config::get('enum.type.OPINION') }}"
          @if(old('type', isset($review->type) ? $review->type : '') == Config::get('enum.type.OPINION'))
             checked
          @endif>
          OPINION
      </label>
      @if ($errors->has('type'))
        <span class="help-block">
            <strong>{{ $errors->first('type') }}</strong>
        </span>
      @endif

      {{-- @if($review->image_name)
        <div class="col-3 p-0">
          <span class="yy-review-img d-block ml-auto" style="background-image: url({{ asset(Config::get('const.IMAGE_FILE_DIRECTORY') . $review->image_name) }})"></span>
        </div>
      @else
        <div class="col-3 p-0">
          <span class="yy-review-img d-block ml-auto yy-bg-powderblue" style="background-image: url({{ asset(Config::get('const.APP_IMAGES_DIRECTORY') . 'yyuxlogo_white.png') }})"></span>
        </div>
      @endif --}}
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

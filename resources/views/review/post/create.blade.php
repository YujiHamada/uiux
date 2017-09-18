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
            <input type="hidden" name="review_id" value="{{isset($review) ? $review->id : ''}}">
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

            <label class="col-12 col-form-label p-0">レビュー画像</label>

            {{-- 追加された写真が格納されていくdiv --}}



            <div class="review-images">
                @foreach( old('review_images', isset($review) ? $review->reviewImages : []) as $reviewImage )
                    @if($reviewImage)
                        {{-- 一度作成したreviewの編集の場合 --}}
                        <div class="review-image d-inline-block pr-3">
                            <input type="hidden" name="review_images[]" value="{{$reviewImage->image_name}}">
                            <div class="col-3 p-0">
                                <span class="yy-review-img d-block" style="background-image: url( {{ asset($reviewImage->image_name) }} )"></span>
                            </div>
                        </div>
                    @else
                        {{-- reviewを新規に作成する場合 --}}
                        <div class="review-image d-inline-block pr-3">
                            <input type="hidden" name="review_images[]" value="{{$reviewImage}}">
                            <div class="col-3 p-0">
                                <span class="yy-review-img d-block" style="background-image: url( {{ asset($reviewImage) }} )"></span>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>

            <div class="add-review-image">
                <a class="my-2 btn btn-outline-primary"><i class="fa fa-camera" aria-hidden="true"></i> 写真を追加する</a>
            </div>


            <button type="submit" class="btn btn-primary">投稿</button>

        </form>



    </div>
@endsection

@section('foot')
  @parent

  @include('review.js.autocomplete-tag-form')
  @include('review.js.input-image-file')
  @include('review.js.enter-tag-form')
  @include('review.js.remove-tag')
  @include('review.js.input-tag')
  @include('review.js.delete-review-confirm')
  <script src="/js/cropper.js"></script>
  <script src="/js/reviewcroppermain.js"></script>

@endsection
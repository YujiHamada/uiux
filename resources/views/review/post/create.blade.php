@extends('layouts.app')

@section('content')
    <div class="col mx-3 px-0">

        @if(isset($review))
            <a href="/review/delete/{{ $review->id }}" onclick="return deleteConfirm();">このレビューを削除</a>｜
            <a href="/post/report/kaizen/{{ $review->id }}">このUXが改善されたことを報告する</a>
        @endif
        <h1 class="mb-4">UXレビューする</h1>
        <form class="form-horizontal" role="form" method="POST" action="{{ url('/post/store') }}" enctype="multipart/form-data">
        	{{ csrf_field() }}
            <input type="hidden" name="review_id" value="{{isset($review) ? $review->id : ''}}">

            <div class="form-group row">
                <label for="title" class="col-lg-2 col-form-label">タイトル<span class="yy-post-annotation"> ※必須</span></label>
                <div class="col-lg-10">
                    <input id="title" type="text" class="form-control" name="title" value="{{ old('title', isset($review->title) ? $review->title : '') }}" required autofocus>
                    @if ($errors->has('title'))
                        <span class="help-block">
                          <strong>{{ $errors->first('title') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group row">
                <label class="col-lg-2 col-form-label">URL</label>
                <div class="col-lg-10">
                    <input id="url" type="text" class="form-control" name="url" value="{{ old('url', isset($review->url) ? $review->url : '') }}">
                    @if ($errors->has('url'))
                        <span class="help-block">
                            <strong>{{ $errors->first('url') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group row">
                <label class="col-lg-2 col-form-label">タグ</label>
                <div class="col-lg-10">
                    @include('review.subs.review-tag')
                </div>
            </div>

            <div class="form-group row">
                <label class="col-lg-2 col-form-label" style="line-height: 1;">UXタイプ <br><a class="yy-post-annotation" href="/about#aboutyyux" target="_blank">※UXタイプとは</a></label>
                <div class="col-lg-10">
                    <div class="form-check col-form-label">
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
                            GOOD UX
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
                    </div>
                </div>

            </div>

            <div class="form-group row">
                <label class="col-12 col-form-label">詳細<span class="yy-post-annotation"> ※必須</span></label>
                <div class="col-12">
                    <textarea id="description" type="text" class="form-control" name="description" rows="8">{{ old('description', isset($review->description) ? $review->description : '') }}</textarea>
                    @if ($errors->has('description'))
                        <span class="help-block">
                            <strong>{{ $errors->first('description') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            @if ($errors->has('type'))
            <span class="help-block">
                <strong>{{ $errors->first('type') }}</strong>
            </span>
            @endif

            <label class="col-12 col-form-label px-0">レビュー参考画像</label>
            @include('review.subs.review-image')

            <div class="text-center my-3">
                <button type="submit" class="yy-pointer btn btn-primary btn-block yy-non-double-click">投稿</button>
            </div>

        </form>



    </div>
@endsection

@section('foot')
  @parent

  @include('review.js.autocomplete-tag-form')
  @include('review.js.enter-tag-form')
  @include('review.js.remove-tag')
  @include('review.js.remove-image')
  @include('review.js.input-tag')
  @include('review.js.delete-review-confirm')
  <script src="/js/cropper.js"></script>
  <script src="/js/reviewcroppermain.js"></script>

@endsection

<div class="tags">
    <div>
        <input class="form-control d-inline-block w-75" type="text" id="tag">
        <button id="tag-btn" class="yy-review-evaluation text-white btn btn-primary" type="button">
            追加
        </button>
    </div>

    @foreach( old('review_tag_names', isset($review) ? $review->reviewTag : []) as $reviewTag )
        @if(isset($reviewTag->tag))
            {{-- 一度作成したreviewの編集の場合 --}}
            <span class="badge badge-pill badge-secondary">
                {{ $reviewTag->tag->name }}
                <span class="removeTag"> ✕</span>
                <input name="review_tag_names[]" type="hidden" value="{{ $reviewTag->tag->name }}">
            </span>
        @else
            {{-- reviewを新規に作成する場合 --}}
            <span class="badge badge-pill badge-secondary">
                {{ $reviewTag }}
                <span class="removeTag"> ✕</span>
                <input name="review_tag_names[]" type="hidden" value="{{ $reviewTag }}">
            </span>
        @endif
    @endforeach

</div>

@if ($errors->has('tags'))
    <span class="help-block">
        <strong>{{ $errors->first('tags') }}</strong>
    </span>
@endif

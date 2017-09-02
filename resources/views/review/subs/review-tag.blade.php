<div class="tags">
    <input type="text" id="tag">
    @foreach( old('review_tag_names', isset($review) ? $review->reviewTag : []) as $reviewTag )
        @if(isset($reviewTag->tag))
            {{-- 一度作成したreviewの編集の場合 --}}
            <span class="badge badge-pill badge-default">
                {{ $reviewTag->tag->name }}
                <span class="removeTag"> ✕</span>
                <input name="review_tag_names[]" type="hidden" value="{{ $reviewTag->tag->name }}">
            </span>
        @else
            {{-- reviewを新規に作成する場合 --}}
            <span class="badge badge-pill badge-default">
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

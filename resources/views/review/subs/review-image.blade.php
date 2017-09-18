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

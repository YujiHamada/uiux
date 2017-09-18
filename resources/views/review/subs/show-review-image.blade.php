<div class="review-images">
    @foreach( $review->reviewImages as $reviewImage )

        <div class="review-image d-inline-block pr-3">
            <input type="hidden" name="review_images[]" value="{{$reviewImage->image_name}}">
            <div class="col-3 p-0">
                <span class="yy-review-img d-block" style="background-image: url( {{ asset($reviewImage->image_name) }} )"></span>
            </div>
        </div>

    @endforeach
</div>

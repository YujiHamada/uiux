<div class="review-images">
    @foreach( $review->reviewImages as $reviewImage )

        <div class="review-image d-inline-block pr-1">
            {{-- <input type="hidden" name="review_images[]" value="{{$reviewImage->image_name}}"> --}}
            <div class="col-3 p-0">
                <span data-target="#timelineModal{{$reviewImage->id}}" class="yy-img-size d-block" style="background-image: url( {{ asset($reviewImage->image_name) }} )" data-toggle="modal"></span>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="timelineModal{{$reviewImage->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        {{-- コンテンツ --}}
                        <div class="modal-body">
                            <span class="yy-modal-img d-block mx-auto" style="background-image: url({{ asset($reviewImage->image_name) }})"></span>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @endforeach
</div>

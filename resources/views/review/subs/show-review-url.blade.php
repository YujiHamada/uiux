@if(!empty($review->url) && !empty($review->url_title))
    <a class="yy-review-url-link" href="{{ $review->url }}" target="_blank">
        <div class="yy-review-url-ogp">
            <div class="media">
                @if(!empty($review->url_image))
                    <img class="yy-review-url-image d-flex align-self-center mr-3" src="{{ asset(Config::get('const.REVIEW_URL_IMAGES_DIRECTORY') . $review->url_image) }}" alt="Generic placeholder image">
                @endif
                <div class="media-body">
                    <h5 class="yy-review-url-title mt-0 mb-1">{{ $review->url_title }}</h5>
                    <p class="yy-review-url-description mb-1">{{ $review->url_description }}</p>
                </div>
            </div>
            <span class="yy-review-domain">{{ !empty($review->domain) ? $review->domain : $review->url}}</span>
        </div>
    </a>
@endif

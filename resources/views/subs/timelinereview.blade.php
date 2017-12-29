<div class="mb-3 p-3 yy-bg-white yy-outline">

    <div class="row mx-0">

        <div class="col-10 col-md-9 p-0 d-flex flex-column">
            <div class="d-flex justify-content-between mb-2">
                {{-- レビュータイトル --}}
                <a class="yy-overflow-hidden" href="{{ !empty($review->is_request) ? '/request/' : '/post/' }}{{ $review->id }}">
                    <h5 class="yy-word-wrap m-0">{{ $review->title }}</h5>
                </a>
                {{-- レビュータイプ --}}
                @include('review.subs.review-type')
            </div>

            {{-- レビュー内容 --}}
            <p class="yy-review-word-wrap text-justify m-0 mb-auto">{{ $review->description }}</p>

            {{-- コメント数、いいね数、わるいね数 --}}
            <div class="mt-1">
                <p class="m-0 d-inline"><i class="fa fa-commenting-o" aria-hidden="true"></i> ： {{ $review->commentsCount()->count() }}</p>
                <p class="m-0 d-inline ml-3"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> ： {{ $review->agreeCount()->count() }}</p>
                <p class="m-0 d-inline ml-3"><i class="fa fa-thumbs-o-down" aria-hidden="true"></i> ： {{ $review->disagreeCount()->count() }}</p>
            </div>
        </div>
        {{-- レビュー画像 --}}
        @if(!$review->reviewImages->isEmpty())
            <div class="col-2 col-md-3 p-0">
                <span data-target="#timelineModal{{$review->id}}" class="yy-timeline-review-img d-block ml-auto" style="background-image: url({{ asset($review->reviewImages->first()->image_name) }})" data-toggle="modal"></span>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="timelineModal{{$review->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        {{-- コンテンツ --}}
                        <div class="modal-body">
                            <span class="yy-modal-img d-block mx-auto" style="background-image: url({{ asset($review->reviewImages->first()->image_name) }})"></span>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="col-2 col-md-3 p-0">
                <span class="yy-timeline-review-img d-block ml-auto yy-bg-powderblue" style="background-image: url({{ asset(Config::get('const.APP_IMAGES_DIRECTORY') . 'yyuxlogo_white.png') }})"></span>
            </div>
        @endif
    </div>


    <div class="row mx-0">
        <div class="col p-0">
            {{-- 投稿ユーザー情報 --}}
            <span class="yy-avatar-thumbnail-img yy-vertical-align-middle" style="background-image: url({{ $review->user->avatar_image_path or '/images/app_images/yyuxlogo_black.png' }})"></span>
            @if(isset($review->user))
                <a class="yy-fontsize-09" href="{{ action('UserController@show', ['username' => isset($review->user->name) ? $review->user->name : '退会済みユーザー']) }}" title="">{{ $review->user->name }}</a>
            @else
                <span class ="yy-fontsize-09">{{ '退会済みユーザー' }}</span>
            @endif
            {{-- タグ --}}
            @foreach($review->reviewTag as $reviewTag)
                <a href="/timeline?tagId={{ $reviewTag->tag->id }}"><span class="badge badge-pill badge-secondary">{{ $reviewTag->tag->name }}</span></a>
            @endforeach
        </div>
        {{-- 投稿時間 --}}
        <div class="col-3 p-0 text-right">
            <p class="text-right m-0 yy-fontsize-09">{{ \App\Libs\Util::agoDateWriting($review->created_at) }}</p>
        </div>
    </div>

</div>

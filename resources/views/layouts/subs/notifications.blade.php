<div class="btn-group mx-2">
    <!-- bootstrapのspacingが効かない？ -->
    <a data-toggle="dropdown" href="#">
        <i class="fa fa-globe fa-2x yy-notifications-icon" aria-hidden="true"></i>
        @if(Auth::user())
        <span class="badge badge-danger yy-unreadnotification-count" style="position: relative;left: -10px; @if(count(Auth::user()->unreadNotifications) == 0) visibility:hidden @endif">
            {{ count(Auth::user()->unreadNotifications) }}
        </span>
        @endif
    </a>
    <div class="dropdown-menu yy-notifications">
        @if(Auth::check())
            <div class="ml-3">
                お知らせ一覧
            </div>
            <div class="dropdown-divider"></div>
            @forelse(Auth::user()->notifications->take(10) as $key => $notification)
                <div>
                    <a class="dropdown-item" href="{{ $notification->data['url'] }}" style="width: 400px;">
                        <div class="row">
                            <div class="col-1 pl-0">
                                <span class="yy-avatar-thumbnail-img yy-vertical-align-middle" style="background-image: url({{ asset(App\User::find($notification->notifier_id)->avatar_image_path) }})"></span>
                            </div>
                            @if(!isset($notification->read_at))
                                <div class="col-1 yy-unreadnotification-mark">
                                    ●
                                </div>
                            @endif
                            <div class="col">
                                <span style="white-space: normal;">{{ $notification->data['message'] }}</span>
                            </div>
                        </div>
                    </a>
                </div>
                @if(count(Auth::user()->notifications) != $key + 1)
                    <div class="dropdown-divider"></div>
                @endif
            @empty
                通知はまだありません
            @endforelse
        @else
            <a href="/login">yyuiuxに登録しよう！</a>
        @endif
    </div>
</div>

@extends('layouts.user')

@section('content')
  <div class="col mx-3">

    <h4>{{ isset($following) ? 'フォロー' : 'フォロワー' }}</h4>

    <div class="followlist">

      {{-- 変数 $following、$followers の設定有無により
      フォローを表示するべきかフォロワーを表示するべきかを判定する --}}
      @if(isset($following))

        {{-- フォロー中のユーザを表示 --}}
        @foreach($following as $follow)
          @include('user.subs.followlist')
        @endforeach

      @elseif(isset($followers))

        {{-- フォロワーを表示 --}}
        @foreach($followers as $follow)
          @include('subs.subs.followlist')
        @endforeach

      @endif
    </div>

  </div>
@endsection

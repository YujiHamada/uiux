@extends('layouts.user')

@section('content')
  <div class="col mx-3">

    <h4>{{ isset($following) ? 'フォロー' : 'フォロワー' }}</h4>

    <div class="followlist">
      @if(isset($following))

        @foreach($following as $follow)
          @include('subs.followlist')
        @endforeach

      @elseif(isset($followers))

        @foreach($followers as $follow)
          @include('subs.followlist')
        @endforeach

      @endif
    </div>

  </div>
@endsection

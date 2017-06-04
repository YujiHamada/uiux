@extends('layouts.app')

<!-- Main Content -->
@section('content')
<div class="container">
  <div class="row">
    <div class="col-8 col-offset-2">

      @include('subs.password-reset')

    </div>
  </div>
</div>
@endsection

{{-- 右サイドバーは不要のため、空で上書き --}}
@section('rightSideBar')
@endsection

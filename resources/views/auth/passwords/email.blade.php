@extends('layouts.app')

<!-- Main Content -->
@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col">

      @include('subs.password-reset')

    </div>
  </div>
</div>
@endsection

{{-- 右サイドバーは不要のため、空で上書き --}}
@section('rightSideBar')
@endsection

@extends('layouts.user')

@section('content')
  <div class="col mx-3 my-3">

    @include('subs.password-reset')

  </div>
@endsection

@section('foot')
  @parent
  <script>
  </script>
@endsection

@extends('layouts.app')

@section('css')
	<style>
		.posted_image{
			max-height: 300px;
			max-width: 300px;
		}
	</style>
@endsection

@section('content')
	<div class = "posted_image">
		<img src="/{{Config::get('const.TEMPORARY_IMAGE_FILE_DIRECTORY')}}{{ $fileName }}" alt=""　class="img-responsive">
	</div>
	<p>タイトル：{{ $title }}</p>
	<p>概要：{{ $description }}</p>

	<form class="form-horizontal" role="form" method="POST" action="{{ url('review/completion') }}" enctype="multipart/form-data">
		{{ csrf_field() }}
		<input type="hidden" name="title" value="{{ $title }}">
		<input type="hidden" name="description" value="{{ $description }}">
		<input type="hidden" name="fileName" value = "{{ $fileName }}">
		<button type="submit" class="btn btn-primary">投稿</button>
	</form>
@endsection

@section('js')
	<script>
	</script>
@endsection

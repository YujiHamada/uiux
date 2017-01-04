@extends('layouts.app')

@section('content')
<div class = "posted_image">
	<img src="/<?= $fileDirectory . $fileName ?>" alt=""　class="img-responsive">
</div>
<p>タイトル：<?php echo $title ?></p>
<p>概要：<?php echo $description ?></p>

<form class="form-horizontal" role="form" method="POST" action="{{ url('post/completion') }}" enctype="multipart/form-data">
	{{ csrf_field() }}
	<input type="hidden" name="title" value="<?= $title ?>">
	<input type="hidden" name="description" value="<?= $description ?>">
	<input type="hidden" name="fileDirectory" value="<?= $fileDirectory ?>">
	<input type="hidden" name="fileName" value = "<?= $fileName ?>">
	<button type="submit" class="btn btn-primary">投稿</button>
</form>




@endsection

@section('js')
<script type="text/javascript" charset="utf-8">



</script>
<style type="text/css" media="screen">
	.posted_image{
		max-height: 300px;
		max-width: 300px;
	}
</style>
@endsection
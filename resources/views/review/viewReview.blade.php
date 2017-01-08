@extends('layouts.app')

@section('css')
<style>
    img {
        width:auto;
        height:auto;
        max-width:120px;
        max-height:150px;
    }
</style>
@endsection

@section('content')
<img src="/{{Config::get('const.IMAGE_FILE_DIRECTORY')}}<?php echo $review->image_name; ?>" alt="">
<h4>タイトル：<?php echo $review->title; ?></h4>
<p>詳細：<?php echo $review->description; ?></p>
@endsection

@section('js')
<scrit>
</script>
@endsection

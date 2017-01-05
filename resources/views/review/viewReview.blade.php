@extends('layouts.app')

@section('content')
<img src="/{{Config::get('const.IMAGE_FILE_DIRECTORY')}}<?php echo $review->image_name; ?>" alt="">
<h4>タイトル：<?php echo $review->title; ?></h4>
<p>詳細：<?php echo $review->description; ?></p>


@endsection

@section('js')
<script type="text/javascript" charset="utf-8">



</script>

<style type="text/css" media="screen">
    img{
        width:auto;
        height:auto;
        max-width:120px;
        max-height:150px;
    }
</style>

@endsection
@extends('layouts.app')

@section('content')
<img src="<?php echo $post->title; ?>" alt="">




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
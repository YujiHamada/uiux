@extends('layouts.app')

@section('content')
    
            <div class="panel panel-default">
                <div class="panel-heading"><a href="{{ url('/post') }}">UIUXレビューを投稿する</a></div>
            </div>

            <div class = "timeline">
            	<?php foreach($posts as $post): ?>
                    <div class = "media">
                        <a class="media-left" href="post/viewPost?id=<?php echo $post->id ?>">
                		<img class="media-object" src="<?php echo $post['image_url'] ?>" alt="がぞう">
                        </a>
                		<div class="media-body">
                            <h4 class="media-heading"><?php echo $post->title ?></h4>
                            <p><?php echo $post->description ?></p>
                        </div>
                    </div>
	            <?php endforeach; ?>
            </div>

@endsection

@section('js')
<script type="text/javascript">
	
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
@extends('layouts.app')

@section('content')
    
            <div class="panel panel-default">
                <div class="panel-heading"><a href="{{ url('/review') }}">UIUXレビューを投稿する</a></div>
            </div>

            <div class = "timeline">
            	<?php foreach($reviews as $review): ?>
                    <div class = "media">
                        <a class="media-left" href="review/viewReview?id=<?php echo $review->id ?>">
                		<img class="media-object" src="{{Config::get('const.IMAGE_FILE_DIRECTORY')}}<?php echo $review->image_name ?>" alt="がぞう">
                        </a>
                		<div class="media-body">
                            <h4 class="media-heading"><?php echo $review->title ?></h4>
                            <p><?php echo $review->description ?></p>
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
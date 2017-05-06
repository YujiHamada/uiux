<?php

namespace App;
use Illuminate\Support\Facades\DB;
use App\ReviewTag;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $table = 'tags';
    public $timestamps = true;

    public static function insertReviewTag($tags, $reviewId){
        $reviewTags = array();

        if(isset($tags)){
            foreach($tags as $key => $tagName){
                $savedTag = Tag::where('name', $tagName)->first();
                $tagId;
                if(!empty($savedTag->id)){
                    $tagId = $savedTag->id;
                    if(count(ReviewTag::where(['review_id' => $reviewId], ['tag_id' => $tagId])->first()) != 0){
                        //同じレビューID、タグIDが存在したらinsertしない
                        continue;
                    }
                }else{
                    $tag = new Tag;
                    $tag->name = $tagName;
                    $tag->save();

                    $tagId = $tag->id;
                }
                array_push($reviewTags, array('tag_id' => $tagId, 'review_id' => $reviewId, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')));
            }
            DB::table('review_tags')->insert($reviewTags);
        }
        
    }

}

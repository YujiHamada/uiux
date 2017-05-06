<?php
namespace App\Libs;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Tag;
use App\ReviewTag;

class Util
{
    public static function agoDateWriting($date)
    {
        switch (true) {
        	case ($date->diffInSeconds(Carbon::now()) < 60):
        		return $date->diffInSeconds(Carbon::now()) . '秒前';
        	case ($date->diffInMinutes(Carbon::now()) < 60):
        		return $date->diffInMinutes(Carbon::now()) . '分前';
        	case ($date->diffInHours(Carbon::now()) < 24):
        		return $date->diffInHours(Carbon::now()) . '時間前';
        	case ($date->diffInDays(Carbon::now()) <  31):
        		return $date->diffInDays(Carbon::now()) . '日前';
        	case ($date->diffInMonths(Carbon::now()) < 12):
        		return $date->diffInMonths(Carbon::now()) . 'ヶ月前';
        	default:
        		return $date;
        }

    }

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
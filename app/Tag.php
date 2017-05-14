<?php

namespace App;
use Illuminate\Support\Facades\DB;
use App\ReviewTag;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $table = 'tags';
    public $timestamps = true;
    protected $fillable = ['name'];

    // 選択されたタグ（$reviewTagNames）をtagsテーブルに作成する。
    public static function insertReviewTag($reviewTagNames, $reviewId){

        foreach($reviewTagNames as $reviewTagName) {
          // tagsテーブルに指定のタグ名がまだないの場合は登録。
          $tag = Tag::firstOrCreate(['name' => $reviewTagName]);
          // review_tagsテーブルに指定のタグがない場合は登録。
          ReviewTag::firstOrCreate(['review_id' => $reviewId, 'tag_id' => $tag->id]);
        }

    }
}

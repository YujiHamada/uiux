<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class SummaryTag extends Model
{
    protected $table = 'summary_tags';
    public $timestamps = true;

    protected $fillable = [
        'tag_id', 'tag_name', 'count'
    ];

    public static function summaryTags(){

      DB::table('summary_tags')->delete();

      $topTenTags = DB::table('review_tag')
                      ->groupBy('tag_id')
                      ->select(DB::raw('tag_id, count(*) as tag_count'))
                      ->orderBy('tag_count', 'desc')
                      ->get(10);

      // dd($topTenTags);

      foreach($topTenTags as $tag){
        $tagId = $tag->tag_id;
        $tagName = Tag::where('id', $tagId)->first()->name;
        $tagCount = $tag->tag_count;

        SummaryTag::create([
                'tag_id' => $tagId,
                'tag_name' => $tagName,
                'count' => $tagCount
        ]);
      }
    }
}

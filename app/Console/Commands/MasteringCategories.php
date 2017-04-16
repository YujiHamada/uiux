<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Tag;

class MasteringTags extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'masteringTags';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //laravel5.3のバグでhaving句が使えない。下のはSELECTするまで書いた。
        //https://github.com/laravel/framework/issues/14908
        // $masteringTagIds = DB::table('review_tag')
        //                             ->select(DB::raw('count(tag_id) as tag_count, tag_id'))
        //                             ->join('tags', 'tags.id', '=', 'review_tag.tag_id')
        //                             ->where('tags.is_master', '=', '0')
        //                             ->groupBy('tag_id')
        //                             ->having('tag_count', '>', 0)
        //                             ->get();
        
        //マスターになっていないタグの取得
        $notmasteredTagIds = DB::table('review_tag')
                                    ->select(DB::raw('count(tag_id) as tag_count, tag_id'))
                                    ->join('tags', 'tags.id', '=', 'review_tag.tag_id')
                                    ->where('tags.is_master', '=', '0')
                                    ->groupBy('tag_id')
                                    ->get();

        $masteringtagIds = array();
        //マスターへの閾値を超えたタグはマスターとして設定
        foreach($notmasteredTagIds as $notmastedTagId){
            if($notmastedTagId->tag_count > \Config::get('const.MASTERING_TAG_THRESHOLD')){
                array_push($masteringTagIds, $notmastedTagId->tag_id);
            }
        }
        DB::table('tags')->whereIn('id', $masteringTagIds)->update(['is_master' => '1']);

    }
}

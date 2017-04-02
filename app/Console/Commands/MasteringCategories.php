<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Category;

class MasteringCategories extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'masteringCategories';

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
        // $masteringCategoryIds = DB::table('review_category')
        //                             ->select(DB::raw('count(category_id) as category_count, category_id'))
        //                             ->join('categories', 'categories.id', '=', 'review_category.category_id')
        //                             ->where('categories.is_master', '=', '0')
        //                             ->groupBy('category_id')
        //                             ->having('category_count', '>', 0)
        //                             ->get();
        
        //マスターになっていないカテゴリーの取得
        $notmasteredCategoryIds = DB::table('review_category')
                                    ->select(DB::raw('count(category_id) as category_count, category_id'))
                                    ->join('categories', 'categories.id', '=', 'review_category.category_id')
                                    ->where('categories.is_master', '=', '0')
                                    ->groupBy('category_id')
                                    ->get();

        $masteringCategoryIds = array();
        //マスターへの閾値を超えたカテゴリーはマスターとして設定
        foreach($notmasteredCategoryIds as $notmastedCategoryId){
            if($notmastedCategoryId->category_count > \Config::get('const.MASTERING_CATEGORY_THRESHOLD')){
                array_push($masteringCategoryIds, $notmastedCategoryId->category_id);
            }
        }
        DB::table('categories')->whereIn('id', $masteringCategoryIds)->update(['is_master' => '1']);

    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Review;
use App\Review_Agree;
use App\Review_Category;
use App\Category;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query;

        if(isset($request->feed) && $request->feed != 'ALL') {
            $query = Review::where('good_or_bad', \Config::get('enum.good_or_bad')[$request->feed])->orderBy('created_at', 'desc');
        }else{
            $query = Review::latest('created_at');
        }

        //検索条件にカテゴリーを加える
        $categoryId = $request->input('categoryId');

        $selectedCategory;

        if(!empty($categoryId)){
            $selectedCategory = Category::select('name')->where('id', $categoryId)->first();
            $query = $this->setCategory($query, $categoryId);
        }

        //検索条件に検索ワードを加える
        $serchWords = $request->input('serchWords');
        $reviews = $this->setSerchWords($query, $serchWords)->paginate(\Config::get('const.NUMBER_OF_REVIEWS_PER_PAGE'));

        $reviews->setPath('?serchWords=' . $serchWords . '&categoryId='. $categoryId);

        return view('home.index', compact('reviews', 'serchWords', 'categoryId', 'selectedCategory'));
        
    }

    private function setSerchWords($query, $serchWords) {
        if(!empty($serchWords)){
            //全角スペースを半角スペースに変換し半角スペースでpreg_split
            $serchWordsArray =preg_split('/[\s]+/',mb_convert_kana($serchWords, 's'));

            $query = $query->Where(function ($q) use(&$serchWordsArray, &$categoryQuery) {
                $categoryQuery = Review_Category::select('review_category.review_id')->join('categories', 'review_category.category_id', 'categories.id');
                foreach($serchWordsArray as $serchWord){
                    $q->orwhere('title', 'like', '%' . $serchWord . '%')->orWhere('description', 'like', '%' . $serchWord . '%');
                    $categoryQuery = $categoryQuery->where('categories.name', 'like', '%' . $serchWord . '%');
                }
                $q->orWhereIn('id', $categoryQuery->get());
            });

        }

        return $query;
    }

    private function setCategory($query, $categoryId) {
        if(!empty($categoryId)){
            $reviewIds = Review_Category::select('review_category.review_id')->join('categories', 'review_category.category_id', 'categories.id')->where('categories.id', $categoryId)->get();
            $query = $query->Where(function ($q) use(&$reviewIds){
                $q->orWhereIn('id', $reviewIds);
            });
        }
        return $query;
    }

    public function categorySerch($categoryId) {
        $ids = Review_Category::select('review_category.review_id')->join('categories', 'review_category.category_id', 'categories.id')->where('categories.id', $categoryId)->get();

        $reviews = Review::whereIn('id',$ids)->paginate(\Config::get('const.NUMBER_OF_REVIEWS_PER_PAGE'));

        return view('home.index', compact('reviews', 'categoryId'));
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Review;
use App\Review_Agree;

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
    public function index()
    {
        $reviews = Review::all()->sortByDesc('created_at');

        // $agreeCount = DB::table('review_agree')->select(DB::raw('count(*) as count'))->where('is_agree', '1')->groupBy('is_agree');

        // echo "<pre>";
        // print_r($agreeCount);
        // echo "</pre>";

        return view('home.index', compact('reviews'));
    }
}

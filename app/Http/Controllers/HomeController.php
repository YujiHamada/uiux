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
        $reviews = Review::latest('created_at')->paginate(5);

        return view('home.index', compact('reviews'));
    }

    public function showGoodTl()
    {
        $reviews = Review::where('good_or_bad', \Config::get('enum.good_or_bad.GOOD'))->latest('created_at')->paginate(5);

        return view('home.index', compact('reviews'));
    }

    public function showBadTl()
    {
        $reviews = Review::where('good_or_bad', \Config::get('enum.good_or_bad.BAD'))->latest('created_at')->paginate(5);

        return view('home.index', compact('reviews'));
    }
}

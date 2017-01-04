<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Post;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // $posts = DB::table('posts')->limit(30)->get();

        $posts = Post::all();

        // echo "<pre>";
        // print_r($posts);
        // echo "</pre>";

        // exit;
        return view('home/home', compact('posts'));
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Review;
use Auth;


class UserController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct(){
      $this->middleware('auth');
  }

  public function show() {
    $user = Auth::user();

    $reviews = Review::where('user_id', $user->id)->get();
    return view('user.show', compact('user', 'reviews'));
  }


}

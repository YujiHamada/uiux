<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Review;
use App\User;
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

  public function show($id) {
    $user = Auth::user();

    // 引数のidが認証ユーザではない場合、
    // 引数のidのユーザを$userに格納する。
    if($id != $user->id) {
      $user = User::where('id', $id)->get();
    }

    $reviews = Review::where('user_id', $user->id)->get();
    return view('user.show', compact('user', 'reviews'));
  }

}

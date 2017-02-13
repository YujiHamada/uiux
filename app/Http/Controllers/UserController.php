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

  public function show($name) {
    $user = Auth::user();

    // 引数のidが認証ユーザではない場合、
    // 引数のidのユーザを$userに格納する。
    if($name != $user->name) {
      $user = User::where('name', $name)->first();
    }

    $reviews = Review::where('user_id', $user->id)->get();
    return view('user.show', compact('user', 'reviews'));
  }

  public function edit($name) {
    $user = Auth::user();

    return view('user.edit', compact('user'));
  }

  public function confirm($name) {
    $user = Auth::user();

    return view('user.edit', compact('user'));
  }

}

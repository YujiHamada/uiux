<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Review;


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
    $user = \Auth::user();

    // TODO:
    // ユーザに紐づくレビューだけ表示したいところだが、
    // 一旦、全てのレビュを投稿
    $reviews = Review::All();
    return view('user.show', compact('user', 'reviews'));
  }


}

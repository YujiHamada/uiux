<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Review;
use App\User;
use Auth;
use App\Libs\CropAvatar;

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

  public function edit() {
    $user = Auth::user();

    return view('user.edit');
  }

  public function confirm() {
    $user = Auth::user();

    return view('user.edit');
  }



  public function crop(Request $request){
    $crop = new CropAvatar(
      Input::has('avatar_src') ? $request->input('avatar_src') : null,
      Input::has('avatar_data') ? $request->input('avatar_data') : null,
      Input::hasFile('avatar_file') ? $_FILES['avatar_file'] : null
    );

    $response = array(
      'state'  => 200,
      'message' => $crop->getMsg(),
      'result' => $crop->getResult() // imageファイルの格納先
    );

    return response()->json($response);

    // echo json_encode($response);
  }

}

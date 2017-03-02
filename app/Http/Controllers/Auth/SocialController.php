<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Socialite;
use App\User;
use Session;


class SocialController extends Controller
{

  /**
   * Where to redirect users after login.
   *
   * @var string
   */
  protected $redirectTo = '/';

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct() {
    $this->middleware('guest', ['except' => 'logout']);
  }


  public function getTwitterAuth() {
    return Socialite::driver('twitter')->redirect();
  }

  public function getTwitterAuthCallback() {
    try {
      $socialUser = Socialite::driver('twitter')->user();
    } catch (\Exception $e) {
      return redirect($this->redirectTo);
    }

    $user = User::where('social_uid', $socialUser->id)->first();

    // ユーザ登録済：認証してログイン
    // ユーザ未登録：ユーザ登録画面へ遷移
    if($user) {
      Auth::login($user, true);
      return redirect($this->redirectTo);
    } else {
      Session::set('social', 'twitter');
      Session::set('social_uid', $socialUser->id);
      $nickname = $socialUser->nickname;
      return view('auth.socialregister', compact('nickname'));
    }
  }


  public function register(Request $request) {
    // TODO: nameとemailが重複していないか確認する必要あり
    $social = Session::get('social');
    $social_uid = Session::get('social_uid');
    $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'social' => $social,
            'social_uid' => $social_uid
    ]);
    Auth::login($user, true);
    return redirect($this->redirectTo);

  }


}

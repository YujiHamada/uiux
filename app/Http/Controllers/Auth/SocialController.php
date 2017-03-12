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

  public function redirectToSocialAuth($provider) {
    return Socialite::driver($provider)->redirect();
  }

  public function handleSocialCallback($provider) {
    try {
      $socialUser = Socialite::driver($provider)->user();
      // dd($socialUser);
    } catch (\Exception $e) {
      return redirect($this->redirectTo);
    }

    $user = User::where('social_uid', $socialUser->id)->first();

    // ユーザ登録済：認証してログイン
    // ユーザ未登録：ユーザ登録画面へ遷移
    if($user) {
      Auth::login($user, true);
      return redirect($this->redirectTo);
    }
    Session::set('social', $provider);
    Session::set('socialUid', $socialUser->id);
    $nickname = $socialUser->nickname;
    $email = $socialUser->email;
    $avatar = ($provider == 'github') ? $socialUser->avatar : $socialUser->avatar_original;

    $data = file_get_contents($avatar);
    $imageResource = imagecreatefromstring($data);
    $width  = imagesx($imageResource); // 横幅
    $height = imagesy($imageResource); // 縦幅

    if ($width >= $height) {
        // 横長の画像の時
        $side = $height;
        $x = floor(($width - $height ) / 2);
        $y = 0;
        $width = $side;
    } else {
        // 縦長の画像の時
        $side = $width;
        $y = floor(($height - $width) / 2);
        $x = 0;
        $height = $side;
    }

    // 出力ピクセルサイズで新規画像作成
    $square_width  = 300;
    $square_height = 300;
    $avatarImagePath = \Config::get('const.USER_IMAGES_DIRECTORY') . $provider . '_' . $socialUser->id . '.jpeg';
    $square_new = imagecreatetruecolor($square_width, $square_height);
    imagecopyresized($square_new, $imageResource, 0, 0, $x, $y, $square_width, $square_height, $width, $height);
    imagejpeg($square_new, $avatarImagePath, 100);

    return view('auth.socialregister', compact('nickname', 'email', 'avatarImagePath'));

  }

  public function handleError() {
    return view('auth.socialregister');
  }

  public function create(\App\Http\Requests\SocialRequest $request) {

    $social = Session::get('social');
    $socialUid = Session::get('socialUid');
    $avatarImagePath = $request->input('avatar_image_path');

    $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'social' => $social,
            'social_uid' => $socialUid,
            'avatar_image_path' => $avatarImagePath
    ]);
    Auth::login($user, true);
    return redirect($this->redirectTo);

  }


}

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Socialite;
use App\User;
use App\SocialProvider;
use Session;
use Illuminate\Support\Facades\DB;


class SocialController extends Controller
{

  /**
   * Where to redirect users after login.
   *
   * @var string
   */
  protected $redirectTo = '/';



  public function redirectToSocialAuth($provider) {
    return Socialite::driver($provider)->redirect();
  }

  public function handleSocialCallback($provider) {
    try {
      $socialUser = Socialite::driver($provider)->user();
    } catch (\Exception $e) {
      return redirect($this->redirectTo);
    }



    // ログイン済み
    // 連携サイトを追加する処理
    if(Auth::check()) {
      $user = Auth::user();
      $socialProvider = SocialProvider::where('user_id', $user->id)->where('social', $provider)->first();
      if($socialProvider) {
        // サイト連携済み。例外処理として、
        // なにもせずにサイト連携画面に戻る
        return redirect('/settings/link');
      }

      // サイト連携情報を作成
      try {
        SocialProvider::create([
                'user_id' => $user->id,
                'social' => $provider,
                'social_uid' => $socialUser->id
        ]);
      } catch (\Exception $e) {
        // 異なるメールアドレスに一つのソーシャルサイトを紐付けようとした場合、
        // 一意制約にかかりエラーとなる。
        return redirect('/settings/link')->with('flash_message', '既に、別メールアドレスにソーシャルアカウントが紐付いています。');;
      }

      return redirect('/settings/link');
    }

    // 未ログイン
    // ユーザ登録済：認証してログイン
    // ユーザ未登録：ユーザ登録画面へ遷移
    $user = DB::table('users')
                ->join('social_providers', 'users.id', '=', 'social_providers.user_id')
                ->where('social_providers.social_uid', '=', $socialUser->id)
                ->where('social_providers.social', '=', $provider)
                ->first();
    if($user) {
      Auth::loginUsingId($user->id, true);
      return redirect($this->redirectTo);
    }

    Session::set('social', $provider);
    Session::set('socialUid', $socialUser->id);
    $nickname = $socialUser->nickname;
    $email = $socialUser->email;
    $fromAvatar = ($provider == 'github') ? $socialUser->avatar : $socialUser->avatar_original;

    $avatarImagePath = \Config::get('const.USER_IMAGES_DIRECTORY') . $provider . '_' . $socialUser->id . '.jpeg';
    $this->createAvatarImage($fromAvatar, $avatarImagePath);

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
            'avatar_image_path' => $avatarImagePath
    ]);

    $socialProvider = SocialProvider::create([
            'user_id' => $user->id,
            'social' => $social,
            'social_uid' => $socialUid
    ]);
    Auth::login($user, true);
    return redirect($this->redirectTo);
  }

  // $fromAvatar(url)のイメージをユーザーサムネイル用に加工し、$toAvatar(url)に保存する。
  private function createAvatarImage($fromAvatar, $toAvatar) {
    $data = file_get_contents($fromAvatar);
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
    $square_new = imagecreatetruecolor($square_width, $square_height);
    imagecopyresized($square_new, $imageResource, 0, 0, $x, $y, $square_width, $square_height, $width, $height);
    imagejpeg($square_new, $toAvatar, 100);
  }


}

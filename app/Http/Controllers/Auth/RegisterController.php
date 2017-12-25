<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Carbon\Carbon;
use App\Mail\UserConfirmation;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255|unique:users,name,NULL,is_deleted,is_deleted,0',
            'email' => 'required|email|max:255|unique:users,NULL,is_deleted,email,is_deleted,0',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
      $confirmation_token = hash_hmac(
          'sha256',
          str_random(40).$data['email'],
          \Config::get('app.key')
      );

      return User::create([
          'name' => $data['name'],
          'email' => $data['email'],
          'password' => bcrypt($data['password']),
          'confirmation_token' => $confirmation_token,
          'confirmation_sent_at' => Carbon::now(),
      ]);
    }

    // Illuminate\Foundation\Auth\RegistersUsersトレイトのメソッドオーバーライド
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        $user = $this->create($request->all());
        event(new Registered($user));


        $this->guard()->login($user);

        $this->sendConfirmMail($user);
        \Session::flash('flash_message', 'ユーザー登録確認メールを送りました。');

        return $this->registered($request, $user)
            ?: redirect($this->redirectPath());
    }

    // ユーザ確認メールを送信
    private function sendConfirmMail(User $user)
    {
        Mail::to($user->email)->send(new UserConfirmation($user));
    }

    // protected function guard(){
    //    return Auth::guard('guard-name');
    // }
}

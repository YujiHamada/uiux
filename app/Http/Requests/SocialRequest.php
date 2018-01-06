<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SocialRequest extends FormRequest
{

    /**
     * Redirect route when errors occur.
     *
     * @var string
     */
    protected $redirectRoute = 'logincallback';

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
          'name' => 'required|max:15|unique:users,name,NULL,is_deleted,is_deleted,0',
          'email' => 'required|email|max:255|unique:users,NULL,is_deleted,email,is_deleted,0',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'ユーザー名を入力してください',
            'name.max' => '15文字以内で入力してください',
            'name.unique' =>' すでに使われているユーザー名です',
            'email.required' => 'メールアドレスを入力してください',
            'email.max' => '255文字以内で入力してください',
            'email.unique' =>' すでに使われているメールアドレスです',
            'email.email' => 'メールアドレスの形式で入力してください',
        ];
    }
}

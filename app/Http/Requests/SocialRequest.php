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
          'name' => 'required|max:255|unique:users,name,NULL,is_deleted,is_deleted,0',
          'email' => 'required|email|max:255|unique:users,NULL,is_deleted,email,is_deleted,0',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '名前が入力されていません',
            'name.max' => '名前は255文字以下で入力してください',
            'name.unique' =>' すでに使われている名前です',
            'email.required' => 'Nameが入力されていません',
            'email.max' => 'メールアドレスは255文字以下で入力してください',
            'email.unique' =>' すでに使われているメールアドレスです',
            'email.email' => 'メールアドレスの形式で入力してください',
        ];
    }
}

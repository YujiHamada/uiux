<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class UserEditRequest extends FormRequest
{
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
          'name' => ['required', 'max:15', 'regex:/^[a-zA-Z0-9]+$/', Rule::unique('users')->ignore(Auth::user()->id)],
          'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore(Auth::user()->id)],
          'biography' => ['max:200'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'ユーザー名を入力してください',
            'name.max' => '15文字以内で入力してください',
            'name.regex' => '半角英数字で入力してください',
            'email.required' => 'メールアドレスを入力してください',
            'email.email' => 'メールアドレスの形式で入力してください',
            'email.max' => '255文字以内で入力してください',
            'biography.max' => '200文字以内で入力してください',

        ];
    }
}

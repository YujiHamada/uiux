<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class ContactRequest extends FormRequest
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
          'name' => ['required', 'max:15'],
          'email' => ['required', 'email', 'max:255'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'ユーザー名を入力してください',
            'name.max' => '15文字以内で入力してください',
            'email.required' => 'メールアドレスを入力してください',
            'email.max' => '255文字以内で入力してください',
            'email.email' => 'メールアドレスの形式で入力してください',
        ];
    }
}

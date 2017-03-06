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
          'name' => 'required|max:255|unique:users',
          'email' => 'required|email|max:255|unique:users',
        ];
    }
}

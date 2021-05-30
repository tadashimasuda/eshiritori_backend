<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
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
            'email' => 'email | required | unique:users,email',
            'name' => 'required',
            'password' => 'required | min:6',
        ];
    }

    public function messages(){
        return [
            'name.required'  => '名前を入力してください。',
            'email.required'  => 'メールアドレスを入力してください。',
            'email.unique'  => 'このメールアドレスはすでに使われています。',
            'email.email'  => 'メールアドレスの形式で入力してください。',
            'password.required'  => 'パスワードを入力してください。',
            'password.min'       => 'パスワードは6文字以上でお願いします。',
        ];
    }
}

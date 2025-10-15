<?php

namespace App\Modules\User\Infrastructure\Http\Request;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => ['required', 'email'],
            'password' => ['required','string','min:8'],
        ];
    }
    public function messages(): array
    {
        return [
            'email.required' => 'Hãy nhập email',
            'email.email' => 'Email không hợp lệ',
            'password.required' => 'Hãy nhập mật khẩu',
            'password.min' => 'Mật khẩu phải có ít nhất 8 kí tự',
        ];
    }

}

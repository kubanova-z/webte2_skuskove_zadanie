<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
{
    public function authorize()
    {
        // Only guests may register
        return $this->user() === null;
    }

    public function rules()
    {
        return [
            'name'     => ['required','string','max:255'],
            'email'    => ['required','email','max:255','unique:users'],
            'password' => ['required','confirmed', Password::defaults()],
        ];
    }
}

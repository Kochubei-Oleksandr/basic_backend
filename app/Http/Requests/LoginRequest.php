<?php

namespace App\Http\Requests;

class LoginRequest extends BaseApiRequest
{
    public function rules()
    {
        return [
            'email' => 'required|email',
            'password' => 'required',
        ];
    }
}

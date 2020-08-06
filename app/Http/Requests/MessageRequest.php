<?php

namespace App\Http\Requests;

class MessageRequest extends BaseApiRequest
{
    public function rules()
    {
        return [
            'email' => 'required|email|max:50',
            'name' => 'required|max:20',
            'message' => 'required|max:255',
        ];
    }
}

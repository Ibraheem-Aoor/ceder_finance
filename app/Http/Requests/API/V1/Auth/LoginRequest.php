<?php

namespace App\Http\Requests\API\V1\Auth;

use App\Http\Requests\API\BaseApiRequest;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends BaseApiRequest   
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string',
        ];
    }
}

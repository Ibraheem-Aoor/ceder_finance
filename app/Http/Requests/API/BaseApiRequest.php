<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class  BaseApiRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->is('api*');
    }

}

<?php

namespace App\Http\Requests\API\V1\Invoice;

use App\Http\Requests\API\BaseApiRequest;
use Illuminate\Foundation\Http\FormRequest;

class InvoiceSubmitRequest extends BaseApiRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'image' => 'required|file|mimes:jpg,jpeg,png,webp|max:2048',
        ];
    }
}

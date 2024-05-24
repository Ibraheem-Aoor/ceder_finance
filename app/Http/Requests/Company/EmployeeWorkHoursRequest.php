<?php

namespace App\Http\Requests\Company;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class EmployeeWorkHoursRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'locations.*.name' => 'required|string',
            'locations.*.hours' => 'required|array',
            'locations.*.hours.*' => 'required|numeric',
            'locations.*.dates' => 'required|array',
            'locations.*.dates.*' => 'required',
            'customer' => 'required',
        ];
    }
}

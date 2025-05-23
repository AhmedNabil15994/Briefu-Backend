<?php

namespace Modules\User\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCVProfileRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        if ($this->isMethod('PUT')) {
            return [
                'country_id' => 'required|exists:countries,id',
                'qualification_id' => 'required',
                'b_day' => 'required',
                'marital_status' => 'nullable|in:married,single,divorced,widowed',
                'nationality_id' => 'nullable|exists:nationalities,id',
                'email' => 'required|email',
                'gender' => 'nullable',
            ];
        }

    }

    public function authorize()
    {
        return true;
    }

    // public function messages()
    // {
    //     $v = [
    //         'name.required' => __('user::api.users.validation.name.required'),
    //         'country_id.required' => __('user::api.users.validation.name.required'),
    //     ];

    //     return $v;
    // }
}

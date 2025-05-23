<?php

namespace Modules\Authentication\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class ResendOtpRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [

            'country_code' => 'required',
            'mobile' => 'required|unique:users,mobile',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function messages()
    {

        return [
            'country_code.required' => __('authentication::api.register.validation.country_code.required'),
            'mobile.required' => __('authentication::api.register.validation.mobile.required'),
            'mobile.unique' => __('authentication::api.register.validation.mobile.unique'),
            'mobile.numeric' => __('authentication::api.register.validation.mobile.numeric'),
            'mobile.digits_between' => __('authentication::api.register.validation.mobile.digits_between'),
        ];
    }
}

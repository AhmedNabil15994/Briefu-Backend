<?php

namespace Modules\User\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMobileRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [

            'mobile' => 'required|unique:users,mobile',
            'otp' => 'required',
            'country_code' => 'required',
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
            'otp.required' => __('user::api.users.validation.otp.required'),
            'mobile.required' => __('user::api.users.validation.mobile.required'),
            'mobile.unique' => __('user::api.users.validation.mobile.unique'),
            'mobile.numeric' => __('user::api.users.validation.mobile.numeric'),
            'mobile.digits_between' => __('user::api.users.validation.mobile.digits_between'),
        ];
    }
}

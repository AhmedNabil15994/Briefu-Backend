<?php

namespace Modules\User\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class CourseRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required'
//            'country_code' => 'required_with:mobile',
        ];
    }

    public function authorize()
    {
        return true;
    }


    public function messages()
    {
        $v = [
            'name.required' => __('apps::frontend.contact_us.validations.username.required'),
        ];

        return $v;
    }
}

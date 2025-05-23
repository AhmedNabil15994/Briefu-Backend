<?php

namespace Modules\User\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class ConsultationRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'consultation' => 'required',
            'ask_contact' => 'required|in:0,1',
        ];
    }

    public function authorize()
    {
        return true;
    }


    public function messages()
    {
        $v = [
            'consultation.required' => __('user::api.validations.consultation.required'),
        ];

        return $v;
    }
}

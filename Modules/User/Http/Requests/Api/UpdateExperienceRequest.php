<?php

namespace Modules\User\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class UpdateExperienceRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch ($this->getMethod()) {
            //handle updates
            case 'put':
            case 'PUT':
                return [
                    'from'                      => 'nullable',
                    'company'                   => 'nullable',
                    'company_address'           => 'nullable',
                    'position'                  => 'nullable',
                ];
        }
    }

    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        $v = [
            'name.required'           => __('user::api.users.validation.name.required'),
        ];

        return $v;
    }
}

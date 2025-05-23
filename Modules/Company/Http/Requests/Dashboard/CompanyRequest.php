<?php

namespace Modules\Company\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch ($this->getMethod())
        {
            // handle creates
            case 'post':
            case 'POST':

                return [
                  'title.*'         => 'required|unique:company_translations,title',
                  'users'           => 'required',
                  'state_id'        => 'required',
                ];

            //handle updates
            case 'put':
            case 'PUT':
                return [
                    'title.*'         => 'required|unique:company_translations,title,'.$this->id.',company_id',
                    'users'           => 'required',
                    'state_id'        => 'required',
                ];
        }
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
        $v = [
            'users.required'        => __('company::dashboard.companies.validation.users.required'),
            'state_id.required'        => __('company::dashboard.companies.validation.state_id.required'),
        ];

        foreach (config('laravellocalization.supportedLocales') as $key => $value) {

          $v["title.".$key.".required"]  = __('company::dashboard.companies.validation.title.required').' - '.$value['native'].'';

          $v["title.".$key.".unique"]    = __('company::dashboard.companies.validation.title.unique').' - '.$value['native'].'';

        }

        return $v;
    }
}

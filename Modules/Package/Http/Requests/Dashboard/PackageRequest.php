<?php

namespace Modules\Package\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class PackageRequest extends FormRequest
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
                  'title.*'         => 'required|unique:package_translations,title',
                ];

            //handle updates
            case 'put':
            case 'PUT':
                return [
                    'title.*'      => 'required|unique:package_translations,title,'.$this->id.',package_id',
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
        foreach (config('laravellocalization.supportedLocales') as $key => $value) {

          $v["title.".$key.".required"]  = __('package::dashboard.packages.validation.title.required').' - '.$value['native'].'';

          $v["title.".$key.".unique"]    = __('package::dashboard.packages.validation.title.unique').' - '.$value['native'].'';

        }

        return $v;
    }
}

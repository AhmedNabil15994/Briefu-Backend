<?php

namespace Modules\Job\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class JobRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title.*' => 'required',
            'company' => 'required|exists:companies,id',
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

        foreach (config('laravellocalization.supportedLocales') as $key => $value) {

            $v["title." . $key . ".required"] = __('job::dashboard.jobs.validation.title.required') . ' - ' . $value['native'] . '';

            $v["title." . $key . ".unique"] = __('job::dashboard.jobs.validation.title.unique') . ' - ' . $value['native'] . '';

        }

        $v['company.required'] = __('job::dashboard.jobs.validation.company_id.required');
        $v['company.exists'] = __('job::dashboard.jobs.validation.company_id.required');

        return $v;

    }
}

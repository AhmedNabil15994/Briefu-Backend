<?php

namespace Modules\Course\Http\Requests\Dashboard;

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
        switch ($this->getMethod())
        {
            // handle creates
            case 'post':
            case 'POST':

                return [
                  'title.*'         => 'required|unique:course_translations,title',
                  'description.*'   => 'required',
                ];

            //handle updates
            case 'put':
            case 'PUT':
                return [
                    'title.*'          => 'required|unique:course_translations,title,'.$this->id.',course_id',
                    'description.*'    => 'required',
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

          $v["title.".$key.".required"]  = __('course::dashboard.courses.validation.title.required').' - '.$value['native'].'';

          $v["title.".$key.".unique"]    = __('course::dashboard.courses.validation.title.unique').' - '.$value['native'].'';

          $v["description.".$key.".required"]  = __('course::dashboard.courses.validation.description.required').' - '.$value['native'].'';

        }

        return $v;

    }
}

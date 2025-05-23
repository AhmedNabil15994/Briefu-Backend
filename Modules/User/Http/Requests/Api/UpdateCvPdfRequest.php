<?php

namespace Modules\User\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCvPdfRequest extends FormRequest
{
    public function rules()
    {
        switch ($this->getMethod()) {
            //handle updates
            case 'post':
                return [
                    'cv_pdf' => 'required|mimes:pdf|max:10000',
                ];
            case 'POST':
                return [
                    'cv_pdf' => 'required|mimes:pdf|max:10000',
                ];
        }
    }

    public function authorize()
    {
        return true;
    }
}

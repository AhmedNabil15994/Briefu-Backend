<?php

namespace Modules\User\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class VideoCvRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'video' => 'required|file|mimes:mp4,mov,ogg,qt',
        ];
    }

    public function authorize()
    {
        return true;
    }
}

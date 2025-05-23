<?php

namespace Modules\Subscription\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class SubscriptionRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'title.*' => 'required',
            'ber_type_id' => 'required|exists:ber_types,id',
            'ber_numbers' => 'required|min:1|numeric',
        ];
        if(!$this->request->has('is_free'))
            $rules['apple_tier_id'] = 'required_without:is_free|exists:apple_tiers,id';

        return $rules;
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
}

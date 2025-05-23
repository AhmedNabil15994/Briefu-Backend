<?php

namespace Modules\Setting\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\Apps\Http\Controllers\Api\ApiController;
use PragmaRX\Countries\Package\Countries;

class SettingController extends ApiController
{
    public function settings()
    {
        $supportedPhoneCodes = $this->supportedPhoneCodes();

        $settings = [
            'social_media'          => setting('social'),
            'contact_us'            => setting('contact_us'),
            'other'                 => setting('other'),
            'currencies'            => setting('currencies'),
            'default_currency'      => setting('default_currency'),
            'countries_phone_code'  => $supportedPhoneCodes
        ];

        return $this->response($settings);
    }

    private function supportedPhoneCodes()
    {
        $supportedPhoneCodes = [];

        foreach (Countries::all() as $key => $value) {
            if (isset($value->dialling) && isset($value->dialling->calling_code)) {

                $country['name']          = $value->name->common;
                $country['code']          = $value->cca2;
                $country['flag']          = optional($value->flag)->emoji;
                $country['calling_code']  = optional(optional($value)->dialling)->calling_code;

                $supportedPhoneCodes[] = $country;
            }
        }

        return $supportedPhoneCodes;
    }
}

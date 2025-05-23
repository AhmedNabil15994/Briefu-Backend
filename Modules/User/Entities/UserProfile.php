<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    protected $fillable = ['marital_status','b_day','graduate_year' , 'gender' , 'faculty' , 'major' , 'state_id' ,'country_id' , 'qualification_id' , 'user_id','mobile','email','cv_pdf','is_fresh_graduate'];
    protected $appends = ['gender_trans'];

    public function state()
    {
        return $this->belongsTo(\Modules\Area\Entities\State::class);
    }

    public function country()
    {
        return $this->belongsTo(\Modules\Area\Entities\Country::class);
    }

    public function qualification()
    {
        return $this->belongsTo(\Modules\Qualification\Entities\Qualification::class);
    }

    public function getGenderTransAttribute()
    {
        $gender = [
            'male' => [
                'en' => 'Male',
                'ar' => 'ذكر',
            ],
            'female' => [
                'en' => 'Female',
                'ar' => 'انثى',
            ]
        ];

        return $this->gender ? $gender[$this->gender][locale()] : $this->gender;
    }

    public function getMaritalStatusTransAttribute()
    {
        $marital_status = [
            'married' => [
                'en' => 'Married',
                'ar' => 'متزوج',
            ],
            'single' => [
                'en' => 'Single',
                'ar' => 'أعزب',
            ],
            'divorced' => [
                'en' => 'Divorced',
                'ar' => 'مطلق',
            ],
            'widowed' => [
                'en' => 'Widowed',
                'ar' => 'أرمل',
            ],
        ];

        return $this->marital_status ? $marital_status[$this->marital_status][locale()] : $this->marital_status;
    }
}

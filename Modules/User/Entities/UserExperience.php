<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;

class UserExperience extends Model
{
    protected $fillable = ['company' , 'company_address' , 'from' , 'to' , 'position' , 'user_id'];

    protected static function booted()
    {
        self::saving(function ($model) {
            if ($model->from && strlen($model->from) === 4) {
                $model->from = $model->from . '-06-15';
            }

            if ($model->to && strlen($model->to) === 4) {
                $model->to = $model->to . '-06-15';
            }
        });
    }
}

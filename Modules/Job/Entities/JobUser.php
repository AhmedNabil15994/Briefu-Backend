<?php

namespace Modules\Job\Entities;

use Illuminate\Database\Eloquent\Model;

class JobUser extends Model
{
    const STATUS = ['new','shortlisted','under_review','approved','rejected'];

    protected $fillable = ['status'];

    public function user()
    {
        return $this->belongsTo(\Modules\User\Entities\User::class);
    }

    public function job()
    {
        return $this->belongsTo(\Modules\Job\Entities\Job::class);
    }

    static function getOptionsForSelect(){
        $options = [];

        foreach (self::STATUS as $status){
            $options[$status] = __('job::dashboard.cvs.form.cv_status_options.'.$status);
        }

        return $options;
    }
}

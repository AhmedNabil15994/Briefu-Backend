<?php

namespace Modules\Job\Entities;

use Illuminate\Database\Eloquent\Model;

class JobFavorite extends Model
{

    protected $table = 'user_favorites';
    
    public function user()
    {
        return $this->belongsTo(\Modules\User\Entities\User::class);
    }

    public function job()
    {
        return $this->belongsTo(\Modules\Job\Entities\Job::class);
    }

}

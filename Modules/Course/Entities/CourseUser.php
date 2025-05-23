<?php

namespace Modules\Course\Entities;

use Illuminate\Database\Eloquent\Model;

class CourseUser extends Model
{
    protected $fillable = ['name', 'email', 'country_code', 'mobile', 'user_id', 'course_id'];

    public function user()
    {
        return $this->belongsTo(\Modules\User\Entities\User::class);
    }

    public function course()
    {
        return $this->belongsTo(\Modules\Course\Entities\Course::class);
    }

}

<?php

namespace Modules\Course\Entities;

use Illuminate\Database\Eloquent\Model;

class CourseTranslation extends Model
{
    protected $fillable = ['description' , 'title' , 'course_id'];
}

<?php

namespace Modules\Job\Entities;

use Illuminate\Database\Eloquent\Model;

class JobTranslation extends Model
{
    protected $fillable = [ 'title' , 'description' ,'slug' ];
}

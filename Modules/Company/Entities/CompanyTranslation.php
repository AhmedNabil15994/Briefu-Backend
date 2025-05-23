<?php

namespace Modules\Company\Entities;

use Illuminate\Database\Eloquent\Model;

class CompanyTranslation extends Model
{
    protected $fillable = [ 'title' , 'slug' ];
}

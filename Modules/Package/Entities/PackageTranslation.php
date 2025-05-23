<?php

namespace Modules\Package\Entities;

use Illuminate\Database\Eloquent\Model;

class PackageTranslation extends Model
{
    protected $fillable = [ 'title', 'description' , 'slug' ];
}

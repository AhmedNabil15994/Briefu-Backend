<?php

namespace Modules\Package\Entities;

use Illuminate\Database\Eloquent\Model;

class PackageLevel extends Model
{
    protected $fillable = ['price' , 'job_posts' , 'video_cv' , 'company_in_home' , 'package_id' , 'months' , 'sort'];

    public function package()
    {
        return $this->belongsTo(Modules\Package\Entities\Package::class);
    }
}

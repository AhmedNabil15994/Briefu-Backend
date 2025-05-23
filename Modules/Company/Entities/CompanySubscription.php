<?php

namespace Modules\Company\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Package\Entities\PackageLevel;

class CompanySubscription extends Model
{
    protected $fillable = ['job_posts' , 'date_from' , 'date_to' , 'video_cv' , 'company_in_home','level_id' ,'package_id' , 'company_id' , 'months' , 'sort' , 'price' , 'is_paid' , 'is_active_now'];

    public function package()
    {
        return $this->belongsTo(
            'Modules\Package\Entities\Package',
        );
    }
    public function level()
    {
        return $this->belongsTo(PackageLevel::class);
    }
}

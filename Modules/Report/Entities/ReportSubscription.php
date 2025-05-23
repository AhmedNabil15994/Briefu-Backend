<?php

namespace Modules\Report\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\ScopesTrait;

class ReportSubscription extends Model
{
  	use ScopesTrait , SoftDeletes;

  	protected $fillable = ['price','date_to','package_id' , 'date_from' , 'months' , 'company_id'];

    public function company()
    {
        return $this->belongsTo(
            'Modules\Company\Entities\Company',
        );
    }

    public function package()
    {
        return $this->belongsTo(
            'Modules\Package\Entities\Package',
        );
    }
}

<?php

namespace Modules\Company\Entities;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Illuminate\Database\Eloquent\SoftDeletes;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\ScopesTrait;

class Company extends Model implements TranslatableContract
{
    use Translatable , SoftDeletes , ScopesTrait;

    protected $with 	= ['translations'];

  	protected $fillable = [
        'status' ,
        'image' ,
        'state_id'
    ];

  	public $translatedAttributes 	        = [ 'title' ];
    public $translationModel 			    = CompanyTranslation::class;

    public function users()
    {
        return $this->belongsToMany(
            'Modules\User\Entities\User',
            'company_users',
            'company_id',
            'user_id'
        );
    }

    public function subscriptions()
    {
        return $this->hasMany(CompanySubscription::class);
    }

    public function jobs()
    {
        return $this->hasMany(\Modules\Job\Entities\Job::class);
    }

    public function specialJobs()
    {
        return $this->hasOne(\Modules\Job\Entities\Job::class)->inRandomOrder();
    }
    public function upcomingSubscriptions()
    {
        return $this->subscriptions()
                    ->where('is_paid',false)
                    ->where('date_from' , '>' , date('Y-m-d'))
                    ->get();
    }

    public function historyOfSubscriptions()
    {
        return $this->subscriptions()
                    ->where('is_paid',false)
                    ->where('date_to'   , '<' , date('Y-m-d'))
                    ->where('date_from' , '<' , date('Y-m-d'))
                    ->get();
    }

    public function activeSubscription()
    {
        return $this->subscriptions()
                    ->where('is_paid',true)
                    ->where('date_from' , '<=' , date('Y-m-d'))
                    ->where(function($query){
                        $query->where( 'date_to', '>=', date('Y-m-d') );
                        $query->orWhere('date_to', '=', null);
                    })
                    ->first();
    }
}

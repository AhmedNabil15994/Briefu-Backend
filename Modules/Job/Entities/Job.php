<?php

namespace Modules\Job\Entities;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Illuminate\Database\Eloquent\SoftDeletes;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Modules\Area\Entities\City;
use Modules\Core\Traits\ScopesTrait;

class Job extends Model implements TranslatableContract
{
  	use Translatable , SoftDeletes , ScopesTrait;
    
    const ACCESS_KEY = 'job';

    protected $with 					    = ['translations'];
  	protected $fillable 					= ['status' , 'company_id','subscription_access'];

    public $translatedAttributes 	        = [ 'title' , 'description' , 'slug' ];
    public $translationModel 			    = JobTranslation::class;

    public function attributes()
    {
        return $this->belongsToMany(\Modules\Attribute\Entities\AttributeValue::class ,
            'job_attribute_values' , 'job_id' , 'attribute_value_id'
        );
    }

    public function categories()
    {
        return $this->belongsToMany(\Modules\Category\Entities\Category::class ,
            'job_categories' , 'job_id' , 'category_id'
        );
    }

    public function cvs()
    {
        return $this->belongsToMany(\Modules\User\Entities\User::class ,
            'job_users' , 'job_id' , 'user_id'
        )->withPivot('user_id','created_at')->withTimestamps();
    }

    public function favorites()
    {
        return $this->belongsToMany(\Modules\User\Entities\User::class ,
            'user_favorites' , 'job_id' , 'user_id'
        )->withTimestamps();
    }

    public function cities()
    {
        return $this->belongsToMany(City::class ,
            'job_cities' , 'job_id' , 'city_id'
        )->withTimestamps();
    }

    public function userCV()
    {
        return $this->hasOne(\Modules\Job\Entities\JobUser::class)->where('user_id',auth()->id());
    }

    public function company()
    {
        return $this->belongsTo(\Modules\Company\Entities\Company::class);
    }

}

<?php

namespace Modules\Course\Entities;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Illuminate\Database\Eloquent\SoftDeletes;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\ScopesTrait;

class Course extends Model implements TranslatableContract
{
  	use Translatable , SoftDeletes , ScopesTrait;

    protected $with               = ['translations'];
  	protected $fillable 	      = [ 'status' , 'image' , 'company_id' , 'price'];
  	public $translatedAttributes  = ['description' , 'title' ];
    public $translationModel 	  = CourseTranslation::class;

    public function users()
    {
        return $this->belongsToMany(
            'Modules\User\Entities\User',
            'course_users',
        );
    }

    public function categories()
    {
        return $this->belongsToMany(
            'Modules\Category\Entities\Category',
            'course_categories',
        );
    }

    public function company()
    {
        return $this->belongsTo('Modules\Company\Entities\Company');
    }

}

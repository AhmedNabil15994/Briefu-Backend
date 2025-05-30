<?php

namespace Modules\Category\Entities;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Illuminate\Database\Eloquent\SoftDeletes;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\ScopesTrait;

class Category extends Model implements TranslatableContract
{
    use Translatable , SoftDeletes , ScopesTrait;

    protected $with 			 = [ 'translations' ];
  	protected $fillable 		 = [ 'status' , 'image' , 'category_id'] ;

  	public $translatedAttributes = [ 'title' , 'slug' , 'description'];
    public $translationModel 	 = CategoryTranslation::class;

    public function parent()
    {
        return $this->belongsTo(Category::class,  'category_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'category_id');
    }

    public function courses()
    {
        return $this->belongsToMany(\Modules\Category\Entities\Category::class,'course_categories');
    }

    public function getParentsAttribute()
    {
        $parents = collect([]);

        $parent = $this->parent;

        while(!is_null($parent)) {
            $parents->push($parent);
            $parent = $parent->parent;
        }

        return $parents;
    }
}

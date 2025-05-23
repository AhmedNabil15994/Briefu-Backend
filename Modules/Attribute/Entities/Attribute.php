<?php

namespace Modules\Attribute\Entities;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\ScopesTrait;

class Attribute extends Model implements TranslatableContract
{
  	use Translatable ,SoftDeletes, ScopesTrait;

    protected $with                = [ 'translations'];
  	protected $fillable 		   = [ 'status' , 'image' , 'is_field'];
  	public $translatedAttributes   = [ 'title' ];
    public $translationModel 	   = AttributeTranslation::class;

    public function values()
    {
        return $this->hasMany(AttributeValue::class);
    }
}

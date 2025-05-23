<?php

namespace Modules\Package\Entities;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Illuminate\Database\Eloquent\SoftDeletes;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\ScopesTrait;

class Package extends Model implements TranslatableContract
{
    use Translatable , SoftDeletes , ScopesTrait;

    protected $with 	= ['translations'];

  	protected $fillable = [
        'status' , 'is_free'
    ];

  	public $translatedAttributes 	        = [ 'title' , 'description' ];
    public $translationModel 			    = PackageTranslation::class;

    public function levels()
    {
        return $this->hasMany(PackageLevel::class);
    }
}

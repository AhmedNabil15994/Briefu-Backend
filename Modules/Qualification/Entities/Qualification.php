<?php

namespace Modules\Qualification\Entities;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Illuminate\Database\Eloquent\SoftDeletes;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\ScopesTrait;

class Qualification extends Model implements TranslatableContract
{
  	use Translatable , SoftDeletes , ScopesTrait;

    protected $with               = ['translations'];
  	protected $fillable 		  = ['status'];
  	public $translatedAttributes  = ['title' ];
    public $translationModel 	  = QualificationTranslation::class;

}

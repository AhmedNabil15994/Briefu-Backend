<?php

namespace Modules\Authorization\Entities;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Modules\Core\Traits\HasTranslations;
use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole
{
		use HasTranslations;
		protected $fillable 					= ['name','display_name','description'];
		public $translatable 	= ['display_name','description'];
}

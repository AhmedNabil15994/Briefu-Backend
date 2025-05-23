<?php

namespace Modules\Catalog\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Core\Traits\Dashboard\CrudModel;
use Modules\Core\Traits\HasTranslations;

class Nationality extends Model
{
    use CrudModel, SoftDeletes, HasTranslations;

    protected $table = 'nationalities';
    protected $fillable = ['status', 'title'];
    public $translatable = ['title'];
}

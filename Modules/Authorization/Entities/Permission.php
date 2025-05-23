<?php

namespace Modules\Authorization\Entities;

use Modules\Core\Traits\HasTranslations;
use Zizaco\Entrust\EntrustPermission;

class Permission extends EntrustPermission
{
    use HasTranslations;

    protected $fillable = ['display_name', 'name', 'description'];
    public $translatable = ['description','display_name'];
}

<?php

namespace Modules\Subscription\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\Dashboard\CrudModel;
use Modules\Core\Traits\HasTranslations;

class BerType extends Model
{
    use CrudModel,HasTranslations;

    protected $table = 'ber_types';
    protected $fillable = array('title', 'days_number');
    public $translatable = ['title'];

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

}

<?php

namespace Modules\Subscription\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\Dashboard\CrudModel;
use Modules\Core\Traits\HasTranslations;

class Possibility extends Model
{
    use CrudModel, HasTranslations;

    protected $table = 'possibilities';
    protected $fillable = array('subscription_id', 'title', 'status');
    public $translatable = ['title'];

    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }

    public function accesses()
    {
        return $this->hasMany(Access::class);
    }

}

<?php

namespace Modules\Subscription\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\Dashboard\CrudModel;
use Modules\Core\Traits\HasTranslations;

class ClientSubscriptionPossibility extends Model
{
    use CrudModel, HasTranslations;

    protected $table = 'client_subscription_possibilities';
    protected $fillable = array('client_subscription_id', 'title', 'status');
    public $translatable = ['title'];

    public function subscription()
    {
        return $this->belongsTo(ClientSubscription::class,'client_subscription_id');
    }

    public function accesses()
    {
        return $this->hasMany(ClientSubscriptionPossibilityAccess::class,'possibility_id');
    }
}

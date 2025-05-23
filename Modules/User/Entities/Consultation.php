<?php

namespace Modules\User\Entities;

use Modules\Subscription\Entities\ClientSubscription;
use Illuminate\Database\Eloquent\Model;

class Consultation extends Model
{
    const ACCESS_KEY = 'consultation';

    protected $fillable = [
        'user_id', 'client_subscription_id', 'consultation', 'ask_contact', 'admin_contact'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subscription()
    {
        return $this->belongsTo(ClientSubscription::class);
    }
}

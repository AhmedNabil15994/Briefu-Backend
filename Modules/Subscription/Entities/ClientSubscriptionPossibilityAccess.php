<?php

namespace Modules\Subscription\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Job\Entities\Job;
use Modules\User\Entities\Consultation;
use Modules\User\Entities\UserCvVideo;

class ClientSubscriptionPossibilityAccess extends Model
{
    const ACCESS_TYPES = [
        UserCvVideo::ACCESS_KEY,
        Job::ACCESS_KEY,
        Consultation::ACCESS_KEY,
    ];

    protected $table = 'client_subscription_possibility_accesses';
    public $timestamps = true;
    protected $fillable = array('possibility_id', 'access_to');

    public function Possibility()
    {
        return $this->belongsTo(ClientSubscriptionPossibility::class,'possibility_id');
    }

    static function accessTypeForSelect(){
        $array = [];
        foreach (self::ACCESS_TYPES as $type){
            $array[$type] = __('subscription::dashboard.subscriptions.form.'.$type);
        }

        return $array;
    }
}

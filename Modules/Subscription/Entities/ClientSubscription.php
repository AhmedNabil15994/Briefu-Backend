<?php

namespace Modules\Subscription\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Modules\Job\Entities\Job;
use Modules\User\Entities\User;
use Modules\User\Entities\UserCvVideo;
use Modules\Core\Traits\Dashboard\CrudModel;
use Modules\Core\Traits\HasTranslations;
use Modules\User\Entities\Consultation;

class ClientSubscription extends Model
{
    use CrudModel, HasTranslations;

    protected $table = 'client_subscription';
    protected $dates = ['expired_date'];
    public $timestamps = true;
    protected $fillable = array(
        'client_id',
        'subscription_id',
        'days_number',
        'expired_date',
        'is_free',
        'title',
        'amount',
        'action_type',
        'discount_value',
        'coupon_id',
        'is_apple_tier',
        'apple_transaction_data',
    );
    public $translatable = ['title'];

    protected $casts = [
        'apple_transaction_data' => 'array',
    ];

    protected function asJson($value)
    {
        return json_encode($value, JSON_UNESCAPED_UNICODE);
    }

    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }

    public function client()
    {
        return $this->belongsTo(User::class,'client_id');
    }

    public function possibilities()
    {
        return $this->hasMany(ClientSubscriptionPossibility::class,'client_subscription_id');
    }

    public function consultation()
    {
        return $this->hasOne(Consultation::class,'client_subscription_id');
    }

    public function accesses()
    {
        return $this->hasManyThrough(ClientSubscriptionPossibilityAccess::class,ClientSubscriptionPossibility::class,'client_subscription_id','possibility_id');
    }

    public function getIsExpiredAttribute()
    {
        return Carbon::now() >= $this->expired_date;
    }

    public function getHasUserCvVideoAccessAttribute()
    {
        return $this->checkAccessWithKey(UserCvVideo::ACCESS_KEY);
    }

    public function getHasJobAccessAttribute()
    {
        return $this->checkAccessWithKey(Job::ACCESS_KEY);
    }

    public function getHasAskConsultationAttribute()
    {
        return $this->checkAccessWithKey(Consultation::ACCESS_KEY);
    }

    private function checkAccessWithKey($key){
        
        return Carbon::now() < $this->expired_date &&
        $this->accesses()->where('access_to', $key)->first() ?
            true :
            false;
    }
}

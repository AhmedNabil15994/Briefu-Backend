<?php

namespace Modules\Subscription\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\Dashboard\CrudModel;
use Modules\Core\Traits\HasTranslations;
use Modules\User\Entities\User;

class Subscription extends Model
{
    use CrudModel,HasTranslations;

    protected $table = 'subscriptions';
    protected $fillable = array('price', 'ber_type_id', 'ber_numbers','title','sub_title','status','is_free','order','apple_tier_id');
    public $translatable = ['title','sub_title'];

    public function clients()
    {
        return $this->belongsToMany(User::class,'client_subscription', 'subscription_id','client_id');
    }

	public function tier()
	{
		return $this->belongsTo(AppleTier::class,'apple_tier_id');
	}

    public function subscriptions()
    {
        return $this->belongsToMany(User::class, 'client_subscription', 'subscription_id','client_id')->wherePivot('paid' , 'paid');
    }

    public function berType()
    {
        return $this->belongsTo(BerType::class);
    }

    public function possibilities()
    {
        return $this->hasMany(Possibility::class);
    }

    public function accesses()
    {
        return $this->hasManyThrough(Access::class,Possibility::class);
    }

    public function getDaysNumberAttribute()
    {
        return $this->berType->days_number * $this->ber_numbers;
    }
}

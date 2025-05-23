<?php

namespace Modules\Coupon\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Core\Traits\ScopesTrait;
use Modules\Subscription\Entities\Subscription;
use Modules\User\Entities\User;

use Spatie\Translatable\HasTranslations;
class Coupon extends Model 
{
    use HasTranslations, SoftDeletes, ScopesTrait;

    protected $with = [];
    protected $guarded = ['id'];

    public $translatable = ['title'];

    public function users()
    {
        return $this->morphedByMany(User::class, 'couponable', 'couponables')->withTimestamps();
    }

    public function subscriptions()
    {
        return $this->morphedByMany(Subscription::class, 'couponable','couponables')->withTimestamps();
    }
}

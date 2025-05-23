<?php

namespace Modules\User\Entities;

use Carbon\Carbon;
use Laravel\Passport\HasApiTokens;
use Modules\Catalog\Entities\Nationality;
use Modules\Core\Traits\ScopesTrait;
use Illuminate\Notifications\Notifiable;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Modules\Subscription\Entities\ClientSubscription;
use Modules\Subscription\Entities\Subscription;

class User extends Authenticatable implements \Tocaan\FcmFirebase\Contracts\IFcmFirebaseDevice
{
    use \Tocaan\FcmFirebase\Traits\FcmDeviceTrait;
    use Notifiable , ScopesTrait , HasApiTokens , SoftDeletes, EntrustUserTrait {
        SoftDeletes::restore insteadof EntrustUserTrait;
        EntrustUserTrait::restore insteadof SoftDeletes;
    }

    protected $dates = [
      'deleted_at'
    ];

    protected $fillable = [
        'name', 'email', 'password', 'mobile' , 'image', 'nationality_id','country_code','is_special'
    ];


    protected $hidden = [
        'password', 'remember_token',
    ];


    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function companies()
    {
        return $this->belongsToMany(
            'Modules\Company\Entities\Company',
            'company_users',
        );
    }

    public function courses()
    {
        return $this->belongsToMany(
            'Modules\Course\Entities\Course',
            'course_users',
        );
    }

    public function target()
    {
        return $this->belongsToMany(
            'Modules\Attribute\Entities\AttributeValue',
            'user_attribute_values',
            'user_id',
            'attribute_value_id'
        );
    }

    public function profileCv()
    {
        return $this->hasOne(UserProfile::class);
    }

    public function videoCv()
    {
        return $this->hasOne(UserCvVideo::class);
    }

    public function experiences()
    {
        return $this->hasMany(UserExperience::class);
    }

    public function nationality()
    {
        return $this->belongsTo(Nationality::class);
    }

    public function certifications()
    {
        return $this->hasMany(UserCertification::class);
    }

    public function qualifications()
    {
        return $this->belongsToMany(\Modules\Qualification\Entities\Qualification::class ,
            'user_qualifications' , 'user_id' , 'qualification_id'
        );
    }

    public function jobs()
    {
        return $this->belongsToMany(\Modules\Job\Entities\Job::class ,
            'job_users'
        );
    }

    public function favorites()
    {
        return $this->belongsToMany(\Modules\Job\Entities\Job::class ,
            'user_favorites' , 'user_id' , 'job_id'
        )->withTimestamps();
    }

    public function getCvVideoPathAttribute()
    {
        if($this->videoCv && $this->videoCv->video){
            return $this->videoCv->video;
        }

        return false;
    }

    //normal user subscriptions

    public function subscription()
    {
        return $this->hasOne(ClientSubscription::class , 'client_id')->where('paid', 'paid')->latest();
    }

    public function activeSubscription()
    {
        return $this->hasOne(ClientSubscription::class , 'client_id')->where('paid', 'paid')->whereDate('expired_date','>',Carbon::now()->toDateString())->latest();
    }

    public function soonExpiringSubscription()
    {
        return $this->hasOne(ClientSubscription::class , 'client_id')->where('paid', 'paid')
        ->whereDate('expired_date','>=',Carbon::now()->toDateString())
        ->whereDate('expired_date','<=',Carbon::now()->addDays(2)->toDateString())
        ->latest();
    }

    public function PendingSubscription()
    {
        return $this->hasOne(ClientSubscription::class , 'client_id')->where('paid', 'pending');
    }

    public function subscriptionsTransactions()
    {
        return $this->belongsToMany(Subscription::class, 'client_subscription','client_id')
            ->withPivot('days_number', 'expired_date', 'paid', 'amount', 'is_free')->withTimestamps();
    }

    public function getSubscriptionTitleAttribute()
    {
        return $this->subscription && $this->subscription->subscription ?
            $this->subscription->subscription->ber_numbers.'/'.optional($this->subscription->subscription->berType)->title.
            ' - '.$this->subscription->subscription->title.'<br><p class="badge badge-danger">expired Date :
            '.Carbon::parse($this->subscription->expired_date)->toDateString().'</p>' : '<p class="badge badge-danger">'.__('user::dashboard.clients.datatable.not_subscribed').'</p>';
    }

    public function getSubscriptionExpiredDateAttribute()
    {
        return $this->subscription ?
            Carbon::parse($this->subscription->expired_date)->toDateString() : null;
    }

    public function getHasVideoCvAccessSubscriptionAttribute()
    {
        return $this->activeSubscription && $this->activeSubscription->has_user_cv_video_access ? true : false;
    }

    public function getHasJobAccessProSubscriptionAttribute()
    {
        return $this->activeSubscription && $this->activeSubscription->has_job_access ? true : false;
    }

    public function getHasAskConsultationAttribute()
    {
        return $this->activeSubscription && $this->activeSubscription->has_ask_consultation ? true : false;
    }

    public function getStrAttrsAttribute()
    {
        $attributes = '';

        foreach($this->target as $attr){

            $attributes .= '<strong>'.optional(optional($attr->attribute)->translate(locale()))->title . '</strong>:'
             . optional($attr->translate(locale()))->title . '<br>';
        }

        return $attributes;
    }

    /**
     * Get all of the clientSubscription for the Client
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subscriptions(): HasMany
    {
        return $this->hasMany(ClientSubscription::class , 'client_id');
    }
}

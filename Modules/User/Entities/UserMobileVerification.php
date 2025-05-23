<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Order\Entities\OrderCourse;
use Modules\User\Entities\UserCvVideo;

class UserMobileVerification extends Model
{
    protected $table = 'user_mobile_verifications';
    protected $fillable = [ 'mobile' , 'otp','otp_expired_date'];
    protected $dates = ['otp_expired_date'];


    public function video() {
        return $this->belongsTo(UserCvVideo::class,'video','api_video_id');
    }
}

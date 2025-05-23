<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Order\Entities\OrderCourse;
use Modules\User\Entities\UserCvVideo;

class ObtainCredential extends Model
{
    protected $table = 'obtain_credentials';
    protected $fillable = [ 'client_payload' , 'api_video_id','status'];


    public function video() {
        return $this->belongsTo(UserCvVideo::class,'video','api_video_id');
    }
}

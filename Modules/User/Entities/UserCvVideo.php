<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\User\Repositories\Api\VideoIntegrationRepository;

class UserCvVideo extends Model
{
    const ACCESS_KEY = 'user_cv_video';
    
    protected $fillable = ['video' , 'user_id'];
    protected $table    = 'user_cv_videos';


    public function credential() {
        return $this->hasOne(ObtainCredential::class,'api_video_id','video');
    }


    public function getVideoStatusAttribute() {
        if(optional($this->credential)->status && optional($this->credential)->status == 'pending') {

            $video_status = VideoIntegrationRepository::checkVideoStatus($this->video);

            if($video_status && $video_status == 'ready') {

                $this->credential()->update(['status' => 'loaded']);
                return 'loaded';
            }
        }
        return optional($this->credential)->status;
    }
}

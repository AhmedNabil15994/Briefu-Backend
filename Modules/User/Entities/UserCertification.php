<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;

class UserCertification extends Model
{
    protected $fillable = ['certificat' , 'address' , 'from' , 'hours' , 'user_id','order'];
}

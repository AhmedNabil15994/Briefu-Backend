<?php

namespace Modules\Subscription\Console;

use Illuminate\Console\Command;
use Illuminate\Http\Request;
use Modules\DeviceToken\Entities\DeviceToken;
use Modules\DeviceToken\Traits\FCMTrait;
use Modules\User\Entities\User;
use Tocaan\FcmFirebase\Facades\FcmFirebase;

class ExpireAlert extends Command
{
    use FCMTrait;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'expire:alert';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $request = new Request;
        $data = [
            'title' => [
                'en' => 'Your subscription will expire soon !',
                'ar' => 'عزيزي المشترك سينتهي اشتراكك قريباً !',
            ],
            'description' => [
                'en' => '',
                'ar' => '',
            ],
        ];
        $request->merge($data);

        $usersIds = User::active()->has('soonExpiringSubscription')->get();

        if(count($usersIds)){
            foreach($usersIds as $user){
                FcmFirebase::sendForUser($user,$data);
            }
//            $devices['ios']     =  DeviceToken::where('platform','IOS')->whereIn('user_id',$usersIds)->orderBy('id', 'desc')->get();
//            $devices['android'] =  DeviceToken::where('platform','ANDROID')->whereIn('user_id',$usersIds)->orderBy('id', 'desc')->get();
//
//            $send = $this->sendNotification($devices,$request);
        }

        $this->info('expiring subscription alertes finished');
    }
}

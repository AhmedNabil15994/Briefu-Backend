<?php


namespace Modules\Authentication\Repositories\Frontend;


use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Modules\User\Entities\PasswordReset;
use Modules\User\Entities\User;

class AuthenticationRepository
{
    function __construct()
    {
        $this->password  = new PasswordReset;
        $this->user      = new User;
    }

    public function findUserByEmail($request)
    {
        $user = $this->user->where('email',$request->email)->first();
        return $user;
    }

    public function createToken($request)
    {
        $user = $this->findUserByEmail($request);

        $this->deleteTokens($user);

        $newToken = strtolower(Str::random(64));

        $token =  $this->password->updateOrCreate(['email'       => $user->email],[
            'email'       => $user->email,
            'token'       => $newToken,
            'created_at'  => Carbon::now(),
        ]);

        $data = [
            'token' => $newToken,
            'user'  => $user
        ];

        return $data;
    }

    public function resetPassword($request)
    {
        $user = $this->findUserByEmail($request);

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        $this->deleteTokens($user);

        return true;
    }

    public function deleteTokens($user)
    {
        $this->password->where('email',$user->email)->delete();
    }

    public function findUser($mobile, $phone_code){
        return  $this->user->where([
                'mobile'       => $mobile,
                'phone_code'   => $phone_code
            ]
        )->first();

    }

    public function resendCode($user){

        $user->update([
            "code_verified" => generateRandomCode(5)
        ]);

    }

    public function resetDevciceToken($user){
        $user->deviceTokens()->update([
            "user_id"=> null
        ]);
    }
}
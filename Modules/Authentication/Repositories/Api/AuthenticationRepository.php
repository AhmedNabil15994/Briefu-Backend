<?php

namespace Modules\Authentication\Repositories\Api;

use Illuminate\Http\Request;
use Modules\Authentication\Traits\Api\MobileVerification;
use Modules\Transaction\Services\SMS\SMS;
use Modules\User\Entities\PasswordReset;
use Modules\User\Entities\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AuthenticationRepository
{
    use MobileVerification;

    private $password;
    private $user;

    function __construct(User $user, PasswordReset $password)
    {
        $this->password = $password;
        $this->user = $user;
    }

    public function register(Request $request)
    {
        DB::beginTransaction();

        try {

            $user = $this->user->create([
                'name' => $request['name'],
                'email' => $request['email'],
                'is_special' => $request->is_special && $request->is_special == 1 ? 1 : 0,
                'mobile' => $request['mobile'],
                'country_code' => $request['country_code'],
                'password' => Hash::make($request['password']),
                'image' => '/uploads/users/user.png',
            ]);

            DB::commit();
            return $user;


        } catch (\Exception $e) {

            DB::rollback();
            throw $e;

        }

    }

    public function companyRegister($request)
    {
        DB::beginTransaction();

        try {

            $user = $this->user->create([
                'name' => $request['name'],
                'email' => $request['email'],
                'mobile' => $request['mobile'],
                'phone_code' => '965',
                'password' => Hash::make($request['password']),
                'image' => '/uploads/users/user.png',
            ]);

            $company = $user->company()->create([
                'image' => 'storage/photos/shares/logo-w.png',
                'status' => false,
                'phone' => $request['mobile'],
                'is_house_keeping_type' => ($request['is_house_keeping_type'] == 'true') ? 1 : 0,
                'is_employees_type' => ($request['is_employees_type'] == 'true') ? 1 : 0,
                'is_health_care' => ($request['is_health_care'] == 'true') ? 1 : 0,
            ]);

            $company->categories()->sync($request->category_id);

            $company->translateOrNew('en')->title = $request->name;
            $company->translateOrNew('ar')->title = $request->name;

            $company->translateOrNew('ar')->description = $request->name;
            $company->translateOrNew('en')->description = $request->name;
            $company->save();

            DB::commit();
            return $user;

        } catch (\Exception $e) {

            DB::rollback();
            throw $e;

        }

    }

    public function findUserByEmail($request)
    {
        $user = $this->user->where('email', $request->email)->first();
        return $user;
    }

    public function createToken($request)
    {
        $user = $this->findUserByEmail($request);

        $this->deleteTokens($user);

        $newToken = strtolower(str_random(64));

        $token = $this->password->insert([
            'email' => $user->email,
            'token' => $newToken,
            'created_at' => Carbon::now(),
        ]);

        $data = [
            'token' => $newToken,
            'user' => $user
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
        $this->password->where('email', $user->email)->delete();
    }

}

<?php

namespace Modules\Authentication\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Modules\Apps\Http\Controllers\Api\ApiController;
use Modules\User\Transformers\Api\UserResource;
use Modules\Authentication\Foundation\Authentication;
use Modules\Authentication\Http\Requests\Api\RegisterRequest;
use Modules\Authentication\Http\Requests\Api\CompanyRegisterRequest;
use Modules\Authentication\Repositories\Api\AuthenticationRepository as AuthenticationRepo;

class RegisterController extends ApiController
{
    use Authentication;

    function __construct(AuthenticationRepo $auth)
    {
        $this->auth = $auth;
    }

    public function register(RegisterRequest $request) 
    {
        $registered = $this->auth->register($request);

        if($registered){

            $this->loginAfterRegister($request);
            return $this->tokenResponse();
        }else{
            return $this->error('Try Again please');
        }
    }

    public function companyRegister(CompanyRegisterRequest $request)
    {
        $registered = $this->auth->companyRegister($request);

        if ($registered):

            $this->loginAfterRegister($request);

            return $this->tokenResponse();

        else:

            return $this->error(__('authentication::api.register.messages.failed'), [], 401);

        endif;

    }

    public function tokenResponse($user = null)
    {
        $user = $user ? $user : auth()->user();

        $token = $this->generateToken($user);

        return $this->response([
            'access_token' => $token->accessToken,
            'user' => new UserResource($user),
            'token_type' => 'Bearer',
            'expires_at' => $this->tokenExpiresAt($token)
        ]);
    }
}

<?php

namespace Modules\Authentication\Http\Controllers\Frontend;

use Modules\Apps\Http\Controllers\Api\ApiController;
use Modules\Authentication\Foundation\Authentication;
use Modules\Authentication\Http\Requests\Frontend\ResetPasswordRequest;
use Modules\Authentication\Repositories\Frontend\AuthenticationRepository;
use Modules\User\Entities\PasswordReset;

class ResetPasswordController extends ApiController
{
    use Authentication;
    private $auth;

    function __construct()
    {
        $this->auth = new AuthenticationRepository();
    }

    public function resetPassword($token)
    {
        abort_unless(PasswordReset::where('token', $token)->first(), 419);
        abort_unless(PasswordReset::where([
            'token' => $token,
            'email' => request('email'),
        ])->first(), 419);
        $email = request('email') ?? '';
        return view('authentication::frontend.password.reset', compact('token', 'email'));
    }


    public function updatePassword(ResetPasswordRequest $request)
    {
        abort_unless(PasswordReset::where('token', $request->token)->first(), 419);
        abort_unless(PasswordReset::where([
            'token' => $request->token,
            'email' => $request->email,
        ])->first(), 419);

        $reset = $this->auth->resetPassword($request);
        $errors = $this->login($request);

        if ($errors) {
            session()->flash('danger_alert', $errors);
        }else{

            session()->flash('success_alert', __('authentication::frontend.password.messages.updated_success'));
        }

        return redirect()->route('frontend.home');
    }
}

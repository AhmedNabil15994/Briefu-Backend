<?php

namespace Modules\User\Http\Controllers\Api;

use Modules\User\Events\ActivityLog;
use Notification;
use Illuminate\Http\Request;
use Modules\User\Http\Requests\Api\UpdateMobileRequest;
use Modules\User\Transformers\Api\UserResource;
use Modules\User\Http\Requests\Api\UpdateProfileRequest;
use Modules\User\Http\Requests\Api\ChangePasswordRequest;
use Modules\User\Repositories\Api\UserRepository as User;
use Modules\Apps\Http\Controllers\Api\ApiController;
use Modules\User\Http\Requests\Api\ConsultationRequest;
use Modules\User\Notifications\Api\ConsultationNotification;

class UserController extends ApiController
{
    private $user;

    function __construct(User $user)
    {
        $this->user = $user;
    }

    public function profile()
    {
        $user =  $this->user->userProfile();
        return $this->response(new UserResource($user));
    }

    public function addConsultation(ConsultationRequest $request)
    {
        $user =  $request->user();
        
        $checkUserAccess = checkUserAccessSubscription($user,'has_ask_consultation');

        if($checkUserAccess)
            return $this->error($checkUserAccess, [], 401);

        $subscription = $user->activeSubscription;

        if($subscription->consultation)
            return $this->error(__('user::api.validations.consultation.you_are_already_asked_your_consultation'), [], 400);

        $consultation = $subscription->consultation()->create([
            'user_id' => $user->id,
            'consultation' => $request->consultation,
            'ask_contact' => $request->ask_contact,
        ]);

        $this->sendNotifications($consultation, $request);
        return $this->response([]);
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        $this->user->update($request);

        $user =  $this->user->userProfile();

        return $this->response(new UserResource($user));
    }

    public function updateMobile(UpdateMobileRequest $request)
    {
        $updateMobile = $this->user->updateMobile($request);

        switch ($updateMobile[0]) {
            case 0:

                return $this->error($updateMobile[1], [], 401);
                break;
            case 1:

                $user =  $this->user->userProfile();
                return $this->response(new UserResource($user));
                break;
            default:

                return '';
                break;

        }
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        $this->user->changePassword($request);

        $user =  $this->user->findById(auth()->id());

        return $this->response(new UserResource($user));
    }


    public function sendNotifications($consultation, $request):void
    {
        try{

            event(new ActivityLog([
                'id' => $consultation->id,
                'type' => 'consultations',
                'url' => url(route('dashboard.reports.consultations.index')),
                'description_en' => 'New consultation',
                'description_ar' => 'إستشاره جديده',
            ]));
    
            Notification::route('mail', setting('contact_us','email'))
            ->notify((new ConsultationNotification($request))->locale(locale()));

        } catch (\PDOException $e) {
            info($e->errorInfo[2]);
        }
    }
}

<?php

namespace Modules\User\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\Apps\Http\Controllers\Api\ApiController;
use Modules\User\Http\Requests\Api\CourseRequest;
use Modules\User\Http\Requests\Api\UpdateCertificationRequest;
use Modules\User\Http\Requests\Api\UpdateCvPdfRequest;
use Modules\User\Http\Requests\Api\UpdateCVProfileRequest;
use Modules\User\Http\Requests\Api\UpdateExperienceRequest;
use Modules\User\Http\Requests\Api\VideoCvRequest;
use Modules\User\Repositories\Api\UserRepository as User;
use Modules\User\Transformers\Api\UserResource;

class UserProfileController extends ApiController
{
    protected $user;
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function updateCV(UpdateCVProfileRequest $request)
    {

        $this->user->updateCV($request);

        $user = $this->user->userProfile();

        return $this->response(new UserResource($user));
    }

    public function UpdateIsFreshGraduate(Request $request)
    {
        auth()->user()->profileCv()->update([

            'is_fresh_graduate' => $request->is_fresh_graduate ?? 0,
        ]);

        return $this->response(new UserResource(auth()->user()));
    }

    public function experiences(UpdateExperienceRequest $request)
    {
        $this->user->updateExperiences($request);

        $user = $this->user->userProfile();

        return $this->response(new UserResource($user));
    }

    public function deleteExperiences($id = null)
    {
        $this->user->deleteExperiences($id);

        $user = $this->user->userProfile();

        return $this->response(new UserResource($user));
    }

    public function qualifications(Request $request)
    {
        $this->user->updateQualifications($request);

        $user = $this->user->userProfile();

        return $this->response(new UserResource($user));
    }

    public function target(Request $request)
    {
        $this->user->addTargetJob($request);

        $user = $this->user->userProfile();

        return $this->response(new UserResource($user));
    }

    public function course(CourseRequest $request)
    {
        $this->user->addCourseRequest($request);

        $user = $this->user->userProfile();

        return $this->response(new UserResource($user));
    }

    public function removeCourse($id)
    {
        $this->user->removeCourse($id);

        $user = $this->user->userProfile();

        return $this->response(new UserResource($user));
    }

    public function certifications(UpdateCertificationRequest $request)
    {
        $this->user->updateCertifications($request);

        $user = $this->user->userProfile();

        return $this->response(new UserResource($user));
    }

    public function deleteCertifications($id = null)
    {
        $this->user->deleteCertifications($id);

        $user = $this->user->userProfile();

        return $this->response(new UserResource($user));
    }

    public function cvPdf(UpdateCvPdfRequest $request)
    {
        $this->user->updateCvPdf($request);

        $user = $this->user->userProfile();

        return $this->response(new UserResource($user));
    }

    public function removeCvPdf(Request $request)
    {
        $this->user->removeCvPdf($request);

        $user = $this->user->userProfile();

        return $this->response(new UserResource($user));
    }

    public function videoCv(VideoCvRequest $request)
    {
        $checkUserAccess = checkUserAccessSubscription($request->user(),'has_video_cv_access_subscription');
        if($checkUserAccess)
            return $this->error($checkUserAccess, [], 401);

        $video = $this->user->uploadVideo($request);

        if ($video) {

            $user = $this->user->userProfile();
            return $this->response(new UserResource($user));

        } else {
            return $this->error('Trial limited to 4 videos. Please purchase a plan to continue.', [], 400);
        }
    }

    public function deleteVideoCv()
    {
        $video = $this->user->deleteVideoCv();

        if ($video) {

            $user = $this->user->userProfile();
            return $this->response(new UserResource($user));

        } else {
            return $this->error('can\'t delete video  .', [], 400);
        }
    }
}

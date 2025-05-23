<?php

namespace Modules\User\Repositories\Api;

use Carbon\Carbon;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Image;
use Modules\Authentication\Traits\Api\MobileVerification;
use Modules\Core\Traits\Attachment\Attachment;
use Modules\Course\Entities\CourseUser;
use Modules\Course\Notifications\Api\CompanyCourseRequestNotification;
use Modules\User\Entities\User;
use Modules\User\Repositories\Api\VideoIntegrationRepository;

class UserRepository
{
    use MobileVerification;

    private $videoIntegrationRepository;

    public function __construct(User $user, CourseUser $course, VideoIntegrationRepository $videoIntegrationRepository)
    {
        $this->user = $user;
        $this->course = $course;
        $this->videoIntegrationRepository = $videoIntegrationRepository;
    }

    public function getAll()
    {
        return $this->user->doesntHave('company')->orderBy('id', 'DESC')->get();
    }

    public function changePassword($request)
    {
        $user = $this->findById(auth()->id());

        if ($request['password'] == null) {
            $password = $user['password'];
        } else {
            $password = Hash::make($request['password']);
        }

        DB::beginTransaction();

        try {
            $user->update([
                'password' => $password,
            ]);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $image = $request['image'] ? $this->updateProfileImage($request['image']) : $user->image;

        if ($request['password'] == null) {
            $password = $user['password'];
        } else {
            $password = Hash::make($request['password']);
        }

        DB::beginTransaction();

        try {
            $user->update([
                'image' => $image,
                'name' => $request['name'] ?? $user->name,
                'country_code' => $request->country_code ?? $user->country_code,
                'mobile' => $request['mobile'] ?? $user->mobile,
                'email' => $request['email'] ?? $user->email,
                'is_special' => $request->is_special && $request->is_special == 1 ? 1 : 0,
                'nationality_id' => $request['nationality_id'] ?? $user->nationality_id,
                'password' => $password,
            ]);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function updateProfileImage($image)
    {
        $fname = md5(rand() * time()) . '.jpg';

        $newPath = public_path('uploads') . '/' . $fname;

        $img = Image::make($image->getRealPath());

        // End of this proccess
        $img->save($newPath);

        $removePath = str_replace(public_path('uploads'), '', $newPath);

        return '/uploads' . $removePath;
    }

    public function updateCV($request)
    {
        $user = auth()->user();

        DB::beginTransaction();

        try {
            $user->profileCv()->updateOrCreate(
                [
                    'user_id' => auth()->id()
                ],
                [
                    'state_id' => $request['state_id'],
                    'country_id' => $request['country_id'],
                    'qualification_id' => $request['qualification_id'],
                    'gender' => isset($request['gender']) ? $request['gender'] : null,
                    'marital_status' => isset($request['marital_status']) ? $request['marital_status'] : null,
                    'graduate_year' => $request['graduate_year'],
                    'b_day' => Carbon::parse($request['b_day'])->toDateString(),
                    'faculty' => $request['faculty'],
                    'major' => $request['major'],
                    'email' => $request['email'],
                    'mobile' => $request->mobile ?? $user->mobile,
                ]
            );

            $userUpdates = [];

            if($request->nationality_id)
                $userUpdates['nationality_id'] = $request['nationality_id'] ?? $user->nationality_id;

            if($request->has('is_special'))
                $userUpdates['is_special'] = $request->is_special && $request->is_special == 1 ? 1 : 0;

            $user->update($userUpdates);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function updateMobile(Request $request)
    {
        $user = auth()->user();

        DB::beginTransaction();

        try {
            $verificationRecordActive = $this->CheckMobileVerification($request->country_code . $request->mobile);

            if (!$verificationRecordActive) {
                return [0, __('user::api.users.otp.messages.otp_is_expired_resend_again')];
            }


            if ($verificationRecordActive->otp != $request->otp) {
                return [0, __('user::api.users.otp.messages.your_otp_is_wrong')];
            }

            $user->mobile = $request->mobile;
            $user->country_code = $request->country_code;
            $user->save();

            $this->deleteMobileCheck($request->country_code . $user->mobile);

            DB::commit();
            return [1, true];
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }


    public function updateQualifications($request)
    {
        $user = auth()->user();

        DB::beginTransaction();

        try {
            $user->qualifications()->sync($request['qualification_id']);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function updateExperiences($request)
    {
        $user = auth()->user();

        DB::beginTransaction();

        try {
            $user->experiences()->delete();

            if(isset($request['company']) && count($request['company'])){

                foreach ($request['company'] as $key => $company) {
                    $user->experiences()->create([
                        'company' => $company,
                        'company_address' => $request['company_address'][$key],
                        'from' => $request['from'][$key] ?? null,
                        'to' => (!isset($request['to'][$key])) ? null : $request['to'][$key],
                        'position' => $request['position'][$key],
                    ]);
                }
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function deleteExperiences($id = null)
    {
        $user = auth()->user();

        DB::beginTransaction();

        try {
            if($id)
                optional($user->experiences()->find($id))->delete();
            else
                $user->experiences()->delete();

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function addCourseRequest($request)
    {
        $user = auth()->user();

        DB::beginTransaction();

        try {
            $courseUser = $this->course->updateOrCreate(
                [
                    'user_id' => $user['id'],
                    'course_id' => $request['course_id'],
                ],
                [
                    'user_id' => $user['id'],
                    'course_id' => $request['course_id'],
                    'name' => $request['name'] ?? $user->name,
                    'email' => $request['email'] ?? $user->email,
                    'country_code' => $request['country_code'] ?? '965',
                    'mobile' => $request->mobile ?? $user->mobile,
                ]
            );

            DB::commit();

            $company = optional($courseUser->course)->company;
            $courseUser->refresh();
            if ($company && $company->users()->count()) {
                Notification::route('mail', [setting('contact_us', 'email'),$company->users()->first()->email])
                    ->notify((new CompanyCourseRequestNotification($request, $courseUser))->locale(locale()));
            }

            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function removeCourse($courseId)
    {
        $user = auth()->user();

        DB::beginTransaction();

        try {
            $user->courses()->detach($courseId);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function addTargetJob($request)
    {
        $user = auth()->user();

        DB::beginTransaction();

        try {
            $user->target()->sync($request['attribute_value_id']);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function updateCertifications($request)
    {
        $user = auth()->user();
        DB::beginTransaction();

        try {
            $user->certifications()->delete();
            foreach ($request['certificat'] as $key => $certificat) {
                $user->certifications()->create([
                    'certificat' => $certificat,
                    'address' => $request['address'][$key],
                    'hours' => isset($request['hours']) ? $request['hours'][$key] : null,
                    'order' => $key,
                ]);
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function deleteCertifications($id = null)
    {
        $user = auth()->user();

        DB::beginTransaction();

        try {
            if($id)
                optional($user->certifications()->find($id))->delete();
            else
                $user->certifications()->delete();

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function updateCvPdf($request)
    {
        $user = auth()->user();
        DB::beginTransaction();

        try {
            if ($user->profileCv) {
                $path = Attachment::updateAttachment($request->cv_pdf, $user->profileCv->cv_pdf, 'cv_pdf');
            } else {
                $path = Attachment::addAttachment($request->cv_pdf, 'cv_pdf');
            }

            $user->profileCv()->updateOrCreate(['user_id' => $user->id], ['cv_pdf' => $path]);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function removeCvPdf($request)
    {
        $user = $request->user();
        DB::beginTransaction();

        try {
            Attachment::deleteAttachment($user->profileCv->cv_pdf);
            $user->profileCv()->updateOrCreate(['user_id' => $user->id], ['cv_pdf' => null]);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function uploadVideo($request)
    {
        $user = auth()->user();

        DB::beginTransaction();

        try {
            if ($user->videoCv) {
                $video = $user->videoCv;
            } else {
                $video = $user->videoCv()->create(['user_id' => $user['id']]);
            }

            // $credential = $this->updateVideo($request, $video);
            $this->updateVideo($request, $video);

            // if (!$credential) {
            //     return false;
            // }

            // $video_link = $credential->api_video_id;
            // $video->update(['video' => $video_link]);

            DB::commit();
            $video->refresh();
            $user->refresh();

            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function deleteVideoCv()
    {
        $user = auth()->user();

        DB::beginTransaction();

        try {
            $video = $user->videoCv;

            if (!$video) {
                return false;
            }

            $delete = $this->deleteVideo($video);

            if (!$delete) {
                return false;
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function userProfile()
    {
        return $this->user->where('id', auth()->id())->first();
    }

    public function findById($id)
    {
        return $this->user->where('id', $id)->first();
    }

    /**
     * @param Request $request
     * @param $video
     * @return mixed
     * @throws \Exception
     */
    private function updateVideo(Request $request, $video)
    {
        $file = $request->file('video');
        $filename = Str::uuid() . '.' . $file->extension();
        // $disk = \App::environment('production') ? 's3' : 'public';

        $path = Storage::disk('s3')->putFileAs(
            'cvs',
            $file,
            $filename,
        );

        // Delete old video file
        if ($video->video) {
            Storage::disk('s3')->delete($video->video);
        }

        $video->update(['video' => $path]);

        return $path;

        // $credential = $this->videoIntegrationRepository->createObtainCredentials();

        // if ($credential) {
        //     $this->videoIntegrationRepository->deleteVideo($video->video);
        //     $video->credential()->delete();
        //     $response = $this->videoIntegrationRepository->uploadVideo($credential, $file);

        //     if (isset($response['status']) && $response['status'] == 1) {
        //         $credential->update(['status' => 'pending']);
        //     }
        // }

        // return $credential;
    }

    /**
     * @param Request $request
     * @param $video
     * @return mixed
     * @throws \Exception
     */
    private function deleteVideo($video)
    {
        if ($video->video) {
            Storage::disk('s3')->delete($video->video);
        }

        return $video->delete();

        // $this->videoIntegrationRepository->deleteVideo($video->video);
        // $video->credential()->delete();
        // return true;
    }
}

<?php

namespace Modules\User\Repositories\Dashboard;

use Carbon\Carbon;
use Modules\Core\Traits\Attachment\Attachment;
use Modules\User\Entities\User;
use Hash;
use DB;
use Illuminate\Http\Request;
use Modules\Subscription\Entities\ClientSubscriptionPossibilityAccess;

class UserRepository
{

    function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getAll()
    {
        return $this->user->doesntHave('companies')->orderBy('id', 'DESC')->get();
    }

    public function CompanyUsersOnly()
    {
        return $this->user->whereHas('roles.perms', function ($query) {
            $query->where('name', 'company_dashboard_access');
        })->doesntHave('companies')->orderBy('id', 'DESC')->get();
    }

    public function userCreatedStatistics()
    {
        $data["userDate"] = $this->user
            ->doesnthave('roles.perms')
            ->select(\DB::raw("DATE_FORMAT(created_at,'%Y-%m') as date"))
            ->groupBy('date')
            ->pluck('date');

        $userCounter = $this->user
            ->doesnthave('roles.perms')
            ->select(\DB::raw("count(id) as countDate"))
            ->groupBy(\DB::raw("DATE_FORMAT(created_at, '%Y-%m')"))
            ->get();

        $data["countDate"] = json_encode(array_pluck($userCounter, 'countDate'));

        return $data;
    }

    public function countUsers($order = 'id', $sort = 'desc')
    {
        $users = $this->user->doesnthave('roles.perms')->count();

        return $users;
    }

    /*
    * Get All Normal Users Without Roles
    */
    public function getAllUsers($order = 'id', $sort = 'desc')
    {
        $users = $this->user->doesnthave('roles.perms')->orderBy($order, $sort)->get();
        return $users;
    }

    /*
    * Find Object By ID
    */
    public function findById($id)
    {
        $user = $this->user->withDeleted()->find($id);
        return $user;
    }

    /*
    * Find Object By ID
    */
    public function findByEmail($email)
    {
        $user = $this->user->where('email', $email)->first();
        return $user;
    }


    /*
    * Create New Object & Insert to DB
    */
    public function create($request)
    {
        DB::beginTransaction();

        try {

            $image = $request['image'] ? Attachment::addAttachment($request['image'], 'users') : '/uploads/users/user.png';

            $user = $this->user->create([
                'name' => $request['name'],
                'email' => $request['email'],
                'mobile' => $request['mobile'],
                'image' => $image,
                'password' => Hash::make($request['password']),
            ]);

            $user->status = $request->status ? 1 : 0;
            $user->is_special = $request->is_special ? 1 : 0;
            $user->save();

            if ($request['roles'] != null)
                $this->saveRoles($user, $request);

            DB::commit();
            return $user;

        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function saveRoles($user, $request)
    {
        foreach ($request['roles'] as $key => $value) {
            $user->attachRole($value);
        }

        return true;
    }

    /*
    * Find Object By ID & Update to DB
    */
    public function update($request, $id)
    {
        DB::beginTransaction();

        $user = $this->findById($id);
        $request->restore ? $this->restoreSoftDelte($user) : null;

        try {

            $image = $request['image'] ? Attachment::updateAttachment($request['image'], $user->image, 'admins') : $user->image;

            if ($request['password'] == null)
                $password = $user['password'];
            else
                $password = Hash::make($request['password']);

            $user->update([
                'name' => $request['name'],
                'email' => $request['email'],
                'mobile' => $request['mobile'],
                'password' => $password,
                'image' => $image,
            ]);

            $user->status = $request->status ? 1 : 0;
            $user->is_special = $request->is_special ? 1 : 0;
            $user->save();

            if ($request['roles'] != null) {
                DB::table('role_user')->where('user_id', $id)->delete();

                foreach ($request['roles'] as $key => $value) {
                    $user->attachRole($value);
                }
            }

            $this->updateSubscription($request,$user);

            DB::commit();
            return true;

        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    protected function updateSubscription(Request $request, $user)
    {
        $subscription = $user->activeSubscription;

        if($subscription){
            $subscription->update([
                'expired_date' => Carbon::parse($request->expired_date)
            ]);

            $accessPossibility = $subscription->possibilities()->whereNull('title')->first();

            if($request->access_to){
    
                if($accessPossibility){

                    $accessPossibility->accesses()->delete();
                }else{
                    $accessPossibility = $subscription->possibilities()->create([
                        'client_subscription_id' => $subscription->id,
                    ]);
                }

                if($request->access_to && count($request->access_to)){
                    foreach ($request->access_to as $access){
                        $this->createAccess($accessPossibility->id , $access);
                    }
                }
            }else{
    
                $accessPossibility->delete();
            }
        }
    }

    private function createAccess($possibility_id,$access_to){
        
        ClientSubscriptionPossibilityAccess::updateOrCreate([

            'possibility_id' => $possibility_id,
            'access_to' =>  $access_to
        ],[
            'possibility_id' => $possibility_id,
            'access_to' =>  $access_to
        ]);
    }

    public function restoreSoftDelte($model)
    {
        $model->restore();
    }

    public function delete($id)
    {
        DB::beginTransaction();

        try {

            $model = $this->findById($id);

            if ($model->trashed()):
                Attachment::deleteAttachment($model->image);
                $model->forceDelete();
            else:
                $model->delete();
            endif;

            DB::commit();
            return true;

        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    /*
    * Find all Objects By IDs & Delete it from DB
    */
    public function deleteSelected($request)
    {
        DB::beginTransaction();

        try {

            foreach ($request['ids'] as $id) {
                $model = $this->delete($id);
            }

            DB::commit();
            return true;

        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    /*
    * Generate Datatable
    */
    public function QueryTable($request)
    {
        $query = $this->user->where('id', '!=', auth()->id())->doesnthave('roles.perms')->where(function ($query) use ($request) {

            $query->where('id', 'like', '%' . $request->input('search.value') . '%');
            $query->orWhere('name', 'like', '%' . $request->input('search.value') . '%');
            $query->orWhere('email', 'like', '%' . $request->input('search.value') . '%');
            $query->orWhere('mobile', 'like', '%' . $request->input('search.value') . '%');

        });

        $query = $this->filterDataTable($query, $request);

        return $query;
    }

    /*
    * Filteration for Datatable
    */
    public function filterDataTable($query, $request)
    {
        // Search Users by Created Dates
        if (isset($request['req']['from']) && $request['req']['from'] != '')
            $query->whereDate('created_at', '>=', $request['req']['from']);

        if (isset($request['req']['to']) && $request['req']['to'] != '')
            $query->whereDate('created_at', '<=', $request['req']['to']);

        if (isset($request['req']['deleted']) && $request['req']['deleted'] == 'only')
            $query->onlyDeleted();

        if (isset($request['req']['deleted']) && $request['req']['deleted'] == 'with')
            $query->withDeleted();

        if (isset($request['req']['user_type']) && $request['req']['user_type'])
            $query->where('is_special', ($request['req']['user_type'] == 'special' ? 1 : 0));

        return $query;
    }

}

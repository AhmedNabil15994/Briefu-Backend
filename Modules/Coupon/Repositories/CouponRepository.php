<?php

namespace Modules\Coupon\Repositories;

use Illuminate\Support\Facades\DB;
use Modules\Coupon\Entities\Coupon;

class CouponRepository
{
    protected $coupon;

    function __construct(Coupon $coupon)
    {
        $this->coupon = $coupon;
    }

    public function findById($id)
    {
        $coupon = $this->coupon->with('subscriptions', 'users')->withDeleted()->find($id);
        return $coupon;
    }

    /**
     * @throws \Exception
     */
    public function create($request)
    {

        DB::beginTransaction();

        try {
            $data = [
                'code' => $request->code <> null ? $request->code : str_random(5),
                'discount_type' => $request->discount_type ?? 'percentage',
                'max_discount_percentage_value' => $request->max_discount_percentage_value ?? null,
                'max_users' => $request->max_users,
                'user_max_uses' => $request->user_max_uses,
                'start_at' => $request->start_at,
                'expired_at' => $request->expired_at,
                'custom_type' => $request->custom_type,
                'status' => $request->status ? 1 : 0,
                'special_clients_only' => $request->special_clients_only ? 1 : 0,
                'flag' => $request->coupon_flag ?? null,
                "title" => $request->title
            ];

            $data['discount_percentage'] = $request->discount_percentage ?? null;
            $data['discount_value'] = null;
            $coupon = $this->coupon->create($data);

            if ($request->subscriptions)
                $coupon->subscriptions()->attach($request->subscriptions);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function update($request, $id)
    {
        DB::beginTransaction();

        $coupon = $this->findById($id);
        $restore = $request->restore ? $this->restoreSoftDelete($coupon) : null;

        try {
            $data = [
                'code' => $request->code,
                'discount_type' => $request->discount_type ?? 'percentage',
                'max_discount_percentage_value' => $request->max_discount_percentage_value ?? null,
                'max_users' => $request->max_users,
                'user_max_uses' => $request->user_max_uses,
                'start_at' => $request->start_at,
                'expired_at' => $request->expired_at,
                'custom_type' => $request->custom_type,
                'status' => $request->status ? 1 : 0,
                'special_clients_only' => $request->special_clients_only ? 1 : 0,
                'flag' => $request->coupon_flag ?? null,
                "title" => $request->title
            ];

            $data['discount_percentage'] = $request->discount_percentage ?? null;
            $data['discount_value'] = null;
            $coupon->update($data);
            $coupon->subscriptions()->sync($request->subscriptions);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function restoreSoftDelete($model)
    {
        $model->restore();
    }

    public function delete($id)
    {
        DB::beginTransaction();

        try {

            $model = $this->findById($id);

            if ($model->trashed()) :
                $model->forceDelete();
            else :
                $model->delete();
            endif;

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

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

    public function QueryTable($request)
    {
        $query = $this->coupon->where(function ($query) use ($request) {
            $query->where('id', 'like', '%' . $request->input('search.value') . '%');
        });

        $query = $this->filterDataTable($query, $request);

        return $query;
    }

    public function filterDataTable($query, $request)
    {
        // SEARCHING INPUT DATATABLE
        if ($request->input('search.value') != null) {

            $query = $query->where(function ($query) use ($request) {
                $query->where('id', 'like', '%' . $request->input('search.value') . '%');
            });
        }

        // FILTER
        if (isset($request['req']['from']) && $request['req']['from'] != '')
            $query->whereDate('created_at', '>=', $request['req']['from']);

        if (isset($request['req']['to']) && $request['req']['to'] != '')
            $query->whereDate('created_at', '<=', $request['req']['to']);

        if (isset($request['req']['deleted']) && $request['req']['deleted'] == 'only')
            $query->onlyDeleted();

        if (isset($request['req']['deleted']) && $request['req']['deleted'] == 'with')
            $query->withDeleted();

        if (isset($request['req']['status']) && $request['req']['status'] == '1')
            $query->active();

        if (isset($request['req']['status']) && $request['req']['status'] == '0')
            $query->unactive();

        return $query;
    }
}

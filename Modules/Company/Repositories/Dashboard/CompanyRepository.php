<?php

namespace Modules\Company\Repositories\Dashboard;

use Modules\Core\Traits\Attachment\Attachment;
use Modules\Package\Traits\SubscriptionCalculations;
use Modules\Company\Entities\Company;
use DB;
use Modules\Report\Entities\ReportSubscription;

class CompanyRepository
{
    use SubscriptionCalculations;

    function __construct(Company $company, ReportSubscription $report)
    {
        $this->company = $company;
        $this->report = $report;
    }

    public function getAll($order = 'id', $sort = 'desc')
    {
        $companies = $this->company->orderBy($order, $sort);

        $company = $this->checkUserCompany();

        if (!empty($company)) {
            $companies->where('id', $company->id);
        }


        return $companies->get();
    }

    public function checkUserCompany()
    {
        $company = auth()->user()->companies()->first();

        if (empty($company)) {
            $company = null;
        }

        return $company;
    }

    public function findById($id)
    {
        $company = $this->company->withDeleted()->find($id);
        return $company;
    }

    public function create($request)
    {
        DB::beginTransaction();

        try {

            $company = $this->company->create([
                'image' => $request->image ? Attachment::addAttachment($request['image'],
                    'companies/images') : setting('logo'),
                'status' => $request->status ? 1 : 0,
                'state_id' => $request->state_id,
            ]);

            $this->translateTable($company, $request);
            if ($request->package && $request->level_id) {
                $this->subscription($company, $request);
            }

            $company->users()->sync($request->users);

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

        $company = $this->findById($id);
        $request->restore ? $this->restoreSoftDelte($company) : null;

        try {

            $company->update([
                'image' => $request->image ? Attachment::updateAttachment($request['image'], $company->image,
                    'companies/images') : $company->image,
                'status' => $request->status ? 1 : 0,
                'state_id' => $request->state_id,
            ]);
            if ($request->package && $request->level_id) {
                $subscriptionCurrent = $company->subscriptions->where('is_active_now',true)->first();
                if(!$subscriptionCurrent){

                    $this->subscription($company, $request);
                }elseif($subscriptionCurrent && $subscriptionCurrent->level_id != $request->level_id){

                    $subscriptionCurrent->delete();
                    $this->subscription($company, $request);
                }
            }

            $this->translateTable($company, $request);
            $company->users()->sync($request->users);

            DB::commit();
            return true;

        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function updateSubscription($request, $id)
    {
        DB::beginTransaction();

        $company = $this->findById($id);
        $request->restore ? $this->restoreSoftDelte($company) : null;

        try {
            if ($request['package']) {

                foreach ($request['date_from'] as $id => $dateFrom) {

                    $company->subscriptions()->find($id)->update([
                        'is_paid' => $request['is_paid'][$id],
                        'date_from' => $dateFrom,
                        'date_to' => $request['date_to'][$id],
                        'job_posts' => $request['job_posts'][$id],
                        'months' => $request['months'][$id],
                        'video_cv' => $request['video_cv'][$id],
                        'price' => $request['price'][$id],
                        'company_in_home' => $request['company_in_home'][$id],
                    ]);

                }
            }

                $this->report($company);
            DB::commit();
            return true;

        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function subscription($company, $request)
    {
        $level = $this->packageLevelById($request->level_id);

        $company->subscriptions()->create([
            'is_paid' => true,
            'is_active_now' => true,
            'date_from' => $level['date_from'],
            'date_to' => $level['date_to'],
            'job_posts' => $level['job_posts'],
            'sort' => $level['sort'],
            'months' => $level['months'],
            'video_cv' => $level['video_cv'],
            'price' => $level['price'],
            'company_in_home' => $level['company_in_home'],
            'package_id' => $level['package_id'],
            'level_id' => $level['level_id'],
            'company_id' => $company['id'],
        ]);

        $this->report($company);
    }

    public function report($company)
    {
        $active = $company->activeSubscription();

        if ($active) {
            $this->report->updateOrCreate(
                [
                    'company_id' => $company['id'],
                    'package_id' => $active['package_id'],
                    'date_from' => $active['date_from'],
                    'date_to' => $active['date_to'],
                    'price' => $active['price'],
                    'months' => $active['months'],
                ],
                [
                    'date_from' => $active['date_from'],
                    'date_to' => $active['date_to'],
                    'months' => $active['months'],
                    'price' => $active['price'],
                    'company_id' => $company['id'],
                    'package_id' => $active['package_id'],
                ]);
        }

    }

    public function newSubscription($company, $request)
    {
        $company->subscriptions()->delete();

        $levels = $this->packageLevels($request);

        foreach ($levels as $key => $level) {
            $company->subscriptions()->create([
                'is_paid' => true,
                'is_active_now' => true,
                'date_from' => $level['date_from'],
                'date_to' => $level['date_to'],
                'job_posts' => $level['job_posts'],
                'sort' => $level['sort'],
                'months' => $level['months'],
                'video_cv' => $level['video_cv'],
                'price' => $level['price'],
                'company_in_home' => $level['company_in_home'],
                'package_id' => $level['package_id'],
                'company_id' => $company['id'],
            ]);
        }

        $this->report($company);

        return true;
    }

    public function restoreSoftDelte($model)
    {
        $model->restore();
    }

    public function translateTable($model, $request)
    {
        foreach ($request['title'] as $locale => $value) {
            $model->translateOrNew($locale)->title = $value;
        }

        $model->save();
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
        $query = $this->company->with(['translations'])->where(function ($query) use ($request) {
            $query->where('id', 'like', '%'.$request->input('search.value').'%');
            $query->orWhere(function ($query) use ($request) {
                $query->whereHas('translations', function ($query) use ($request) {
                    $query->where('title', 'like', '%'.$request->input('search.value').'%');
                });
            });
        });

        $query = $this->filterDataTable($query, $request);

        return $query;
    }

    public function filterDataTable($query, $request)
    {
        // Search Categories by Created Dates
        if (isset($request['req']['from']) && $request['req']['from'] != '') {
            $query->whereDate('created_at', '>=', $request['req']['from']);
        }

        if (isset($request['req']['to']) && $request['req']['to'] != '') {
            $query->whereDate('created_at', '<=', $request['req']['to']);
        }

        if (isset($request['req']['deleted']) && $request['req']['deleted'] == 'only') {
            $query->onlyDeleted();
        }

        if (isset($request['req']['deleted']) && $request['req']['deleted'] == 'with') {
            $query->withDeleted();
        }

        if (isset($request['req']['status']) && $request['req']['status'] == '1') {
            $query->active();
        }

        if (isset($request['req']['status']) && $request['req']['status'] == '0') {
            $query->unactive();
        }

        return $query;
    }

}

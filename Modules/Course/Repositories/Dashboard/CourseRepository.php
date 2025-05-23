<?php

namespace Modules\Course\Repositories\Dashboard;

use Modules\Core\Traits\Attachment\Attachment;
use Modules\Course\Entities\Course;
use Hash;
use DB;

class CourseRepository
{

    function __construct(Course $course)
    {
        $this->course = $course;
    }

    public function getAllActive($order = 'id', $sort = 'desc')
    {
        $courses = $this->course->active()->orderBy($order, $sort)->get();
        return $courses;
    }

    public function getAll($order = 'id', $sort = 'desc')
    {
        $courses = $this->course->orderBy($order, $sort)->get();
        return $courses;
    }

    public function findById($id)
    {
        $course = $this->course->withDeleted()->find($id);
        return $course;
    }

    public function create($request)
    {
        DB::beginTransaction();

        try {

            $course = $this->course->create([
                'image' => $request->image ? Attachment::addAttachment($request['image'], 'courses') : setting('logo'),
                'status' => $request->status ? 1 : 0,
                'price' => $request->price,
                'company_id' => $request->company_id ? $request->company_id : null,
            ]);

            $course->categories()->sync($request['categories']);
            $this->translateTable($course, $request);

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

        $course = $this->findById($id);
        $request->restore ? $this->restoreSoftDelte($course) : null;

        try {

            $course->update([
                'image' => $request->image ? Attachment::updateAttachment($request['image'], $course->image, 'courses') : $course->image,
                'status' => $request->status ? 1 : 0,
                'price' => $request->price,
                'company_id' => $request->company_id ? $request->company_id : null,
            ]);

            $course->categories()->sync($request['categories']);
            $this->translateTable($course, $request);

            DB::commit();
            return true;

        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function restoreSoftDelte($model)
    {
        $model->restore();
    }

    public function translateTable($model, $request)
    {
        foreach ($request['title'] as $locale => $value) {
            $model->translateOrNew($locale)->title = $value;
            $model->translateOrNew($locale)->description = $request['description'][$locale];
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
        $query = $this->course->where(function ($query) use ($request) {
            $query->where('id', 'like', '%' . $request->input('search.value') . '%');
            $query->orWhere(function ($query) use ($request) {
                $query->whereHas('translations', function ($query) use ($request) {
                    $query->where('description', 'like', '%' . $request->input('search.value') . '%');
                    $query->orWhere('title', 'like', '%' . $request->input('search.value') . '%');
                });
            });
        });

        $company = $this->checkUserCompany();

        if (!empty($company))
            $query->where('company_id', $company->id);

        $query = $this->filterDataTable($query, $request);

        return $query;
    }

    public function filterDataTable($query, $request)
    {
        // Search Courses by Created Dates
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

    public function checkUserCompany()
    {
        $company = auth()->user()->companies()->first();

        if (empty($company))
            $company = null;

        return $company;
    }

}

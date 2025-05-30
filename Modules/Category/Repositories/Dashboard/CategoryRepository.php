<?php

namespace Modules\Category\Repositories\Dashboard;

use Modules\Category\Entities\Category;
use DB;
use Modules\Core\Traits\Attachment\Attachment;

class CategoryRepository
{
    function __construct(Category $category)
    {
        $this->category = $category;
    }

    public function getAll($order = 'id', $sort = 'desc')
    {
        $categories = $this->category->orderBy($order, $sort)->get();
        return $categories;
    }

    public function countCategories($order = 'id', $sort = 'desc')
    {
        $categories = $this->category->orderBy($order, $sort)->count();
        return $categories;
    }

    public function mainCategories($order = 'id', $sort = 'desc')
    {
        $categories = $this->category->mainCategories()->orderBy($order, $sort)->get();
        return $categories;
    }

    public function findById($id)
    {
        $category = $this->category->withDeleted()->find($id);
        return $category;
    }

    public function create($request)
    {
        DB::beginTransaction();

        try {

            $category = $this->category->create([
                'image' => $request->image ? Attachment::addAttachment($request['image'], 'categories') : setting('logo'),
                'status' => $request->status ? 1 : 0,
                'category_id' => ($request->category_id != "null") ? $request->category_id : null,
            ]);

            $this->translateTable($category, $request);

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

        $category = $this->findById($id);
        $request->restore ? $this->restoreSoftDelte($category) : null;

        try {

            $category->update([
                'image' => $request->image ? Attachment::updateAttachment($request['image'], $category->image, 'categories') : $category->image,
                'status' => $request->status ? 1 : 0,
                'category_id' => ($request->category_id != "null") ? $request->category_id : null,
            ]);

            $this->translateTable($category, $request);

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
            $model->translateOrNew($locale)->slug = slugfy($value);
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
        $query = $this->category->with(['translations'])->where(function ($query) use ($request) {
            $query->where('id', 'like', '%' . $request->input('search.value') . '%');
            $query->orWhere(function ($query) use ($request) {
                $query->whereHas('translations', function ($query) use ($request) {
                    $query->where('title', 'like', '%' . $request->input('search.value') . '%');
                    $query->orWhere('slug', 'like', '%' . $request->input('search.value') . '%');
                });
            });
        });

        $query = $this->filterDataTable($query, $request);

        return $query;
    }

    public function filterDataTable($query, $request)
    {
        // Search Categories by Created Dates
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

<?php

namespace Modules\Core\Repositories\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Core\Traits\RepositorySetterAndGetter;
use Modules\Core\Traits\Dashboard\HandleStatusAndFile;

class ApiCrudRepository
{
    use RepositorySetterAndGetter;
    use HandleStatusAndFile;


    public function __construct($model = null)
    {
        $this->model = $model ? new $model : $model;
    }

    /**
     * Append custom filter
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function appendFilter(&$query, $request): \Illuminate\Database\Eloquent\Builder
    {
        return $query;
    }

    /**
     * Append custom filter
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function appendSearch(&$query, $request): \Illuminate\Database\Eloquent\Builder
    {
        return $query;
    }

    public function getAllActive($order = 'id', $sort = 'desc')
    {
        return $this->getModel()->active()->orderBy($order, $sort)->get();
    }

    public function take(Request $request, $order = 'id', $sort = 'desc')
    {
        return $this->getModel()->active()->orderBy($order, $sort)->take($request->takeCount ?? 5)->get();
    }

    public function getPagination(Request $request, $order = 'id', $sort = 'desc')
    {
        return $this->getModel()->active()
            ->where(function ($query) use ($request) {

                $query->where('id', 'like', '%'.$request->search_key.'%');
                $this->appendSearch($query, $request);
                foreach ($this->getModelTranslatable() as $key) {
                    $query->orWhere($key.'->'.locale(), 'like', '%'.$request->search_key.'%');
                }
            })
            ->where(function ($query) use ($request) {
                $this->appendFilter($query, $request);
            })
            ->orderBy($order, $sort)->paginate($request->pageCount ?? 10);
    }

    public function getAll($order = 'id', $sort = 'desc')
    {
        return $this->getModel()->active()->orderBy($order, $sort)->get();
    }

    public function findById($id)
    {
        return $this->getModel()->active()->find($id);
    }
}

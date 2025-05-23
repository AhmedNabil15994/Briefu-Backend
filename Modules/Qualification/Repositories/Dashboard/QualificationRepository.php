<?php

namespace Modules\Qualification\Repositories\Dashboard;

use Modules\Qualification\Entities\Qualification;
use Hash;
use DB;

class QualificationRepository
{

    function __construct(Qualification $qualification)
    {
        $this->qualification   = $qualification;
    }

    public function getAllActive($order = 'id', $sort = 'desc')
    {
        $qualifications = $this->qualification->active()->orderBy($order, $sort)->get();
        return $qualifications;
    }

    public function getAll($order = 'id', $sort = 'desc')
    {
        $qualifications = $this->qualification->orderBy($order, $sort)->get();
        return $qualifications;
    }

    public function findById($id)
    {
        $qualification = $this->qualification->withDeleted()->find($id);
        return $qualification;
    }

    public function create($request)
    {
        DB::beginTransaction();

        try {

          $qualification = $this->qualification->create([
            'status'   => $request->status ? 1 : 0,
          ]);

          $this->translateTable($qualification,$request);

          DB::commit();
          return true;

        }catch(\Exception $e){
            DB::rollback();
            throw $e;
        }
    }

    public function update($request,$id)
    {
        DB::beginTransaction();

        $qualification = $this->findById($id);
        $restore = $request->restore ? $this->restoreSoftDelte($qualification) : null;

        try {

            $qualification->update([
              'status'   => $request->status ? 1 : 0,
            ]);

            $this->translateTable($qualification,$request);

            DB::commit();
            return true;

        }catch(\Exception $e){
            DB::rollback();
            throw $e;
        }
    }

    public function restoreSoftDelte($model)
    {
        $model->restore();
    }

    public function translateTable($model,$request)
    {
        foreach ($request['title'] as $locale => $value) {
            $model->translateOrNew($locale)->title           = $value;
        }

        $model->save();
    }

    public function delete($id)
    {
        DB::beginTransaction();

        try {

            $model = $this->findById($id);

            if ($model->trashed()):
              $model->forceDelete();
            else:
              $model->delete();
            endif;

            DB::commit();
            return true;

        }catch(\Exception $e){
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

        }catch(\Exception $e){
            DB::rollback();
            throw $e;
        }
    }

    public function QueryTable($request)
    {
        $query = $this->qualification->where(function($query) use($request){
                      $query->where('id', 'like' , '%'. $request->input('search.value') .'%');
                      $query->orWhere( function( $query ) use($request){
                          $query->whereHas('translations', function($query) use($request) {
                              $query->where('title'        , 'like' , '%'. $request->input('search.value') .'%');
                          });
                      });
                });

        $query = $this->filterDataTable($query,$request);

        return $query;
    }

    public function filterDataTable($query,$request)
    {
        // Search Qualifications by Created Dates
        if (isset($request['req']['from']) && $request['req']['from'] != '')
            $query->whereDate('created_at'  , '>=' , $request['req']['from']);

        if (isset($request['req']['to']) && $request['req']['to'] != '')
            $query->whereDate('created_at'  , '<=' , $request['req']['to']);

        if (isset($request['req']['deleted']) &&  $request['req']['deleted'] == 'only')
            $query->onlyDeleted();

        if (isset($request['req']['deleted']) &&  $request['req']['deleted'] == 'with')
            $query->withDeleted();

        if (isset($request['req']['status']) &&  $request['req']['status'] == '1')
            $query->active();

        if (isset($request['req']['status']) &&  $request['req']['status'] == '0')
            $query->unactive();

        return $query;
    }

}

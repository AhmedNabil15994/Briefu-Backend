<?php

namespace Modules\Subscription\Repositories\Dashboard;

use Illuminate\Http\Request;
use Modules\Core\Repositories\Dashboard\CrudRepository;
use Modules\Subscription\Entities\Access;
use Modules\Subscription\Entities\Possibility;
use Illuminate\Support\Facades\DB;

class PossibilityRepository extends CrudRepository
{
    public function __construct()
    {
        parent::__construct(Possibility::class);
    }

    public function prepareData(array $data, Request $request, $is_create = true): array
    {
        if($request->has('active_possibility_title')){

            $data['title'] = $request->active_possibility_title;
            $data['status'] = $request->active_status_possibility ?? 0;
            
        }else{
            unset($data['title']);
            $data['status'] = 1;
        }
        
        return parent::prepareData($data, $request, $is_create);
    }

    public function modelCreated($model, $request, $is_created = true): void
    {
        if($request->active_possibility_access_to && count($request->active_possibility_access_to)){
            foreach ($request->active_possibility_access_to as $access){
                $this->createAccess($model->id , $access);
            }
        }

        parent::modelCreated($model, $request, $is_created);
    }

    public function modelUpdated($model, $request): void
    {
        $model->accesses()->delete();
        if($request->active_possibility_access_to && count($request->active_possibility_access_to)){
            foreach ($request->active_possibility_access_to as $access){
                $this->createAccess($model->id , $access);
            }
        }
        parent::modelUpdated($model, $request);
    }

    private function createAccess($possibility_id,$access_to){
        
        Access::updateOrCreate([

            'possibility_id' => $possibility_id,
            'access_to' =>  $access_to
        ],[
            'possibility_id' => $possibility_id,
            'access_to' =>  $access_to
        ]);
    }
}

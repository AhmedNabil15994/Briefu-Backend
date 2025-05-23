<?php

namespace Modules\Subscription\Repositories\Dashboard;

use Illuminate\Http\Request;
use Modules\Core\Repositories\Dashboard\CrudRepository;
use Modules\Subscription\Entities\Subscription;
use Modules\Subscription\Entities\Possibility;

class SubscriptionRepository extends CrudRepository
{
    private $possibility;

    public function __construct()
    {
        parent::__construct(Subscription::class);
        $this->possibility = new PossibilityRepository;
        $this->statusAttribute = ['status', 'is_free'];
    }

    public function prepareData(array $data, Request $request, $is_create = true): array
    {
        if ($request->is_free && $request->is_free == 'on') {
            $data['price'] = 0;
        }

        if ($is_create) {
            $data['order'] = $request->order ?? $this->model->count() + 1;
        }
        return parent::prepareData($data, $request, $is_create);
    }

    public function modelCreated($model, $request, $is_created = true): void
    {
        $request->merge([
            'subscription_id' => $model->id
        ]);

        if($request->access_to){
            $request->merge([
                'active_possibility_access_to' => isset($request->access_to) ? $request->access_to : null,
            ]);

            $this->possibility->create($request);
        }
        if ($request->title_possibility && count($request->title_possibility)) {

            foreach ($request->title_possibility as $key => $value) {
                if ($key != '::index') {
                    $request->merge([
                        'active_possibility_title' => $request->title_possibility[$key],
                        'active_status_possibility' => isset($request->status_possibility[$key]) && $request->status_possibility[$key] ? 1 : 0,
                    ]);

                    $this->possibility->create($request);
                }
            }
        }

        parent::modelCreated($model, $request, $is_created);
    }

    public function modelUpdated($model, $request): void
    {
        $possibilities_ids = $model->possibilities()->whereNotNull('title')->pluck('id')->toArray();
        $accessPossibility = $model->possibilities()->whereNull('title')->first();
        $request->merge([
            'subscription_id' => $model->id
        ]);

        if($request->access_to){
            $request->merge([
                'active_possibility_access_to' => isset($request->access_to) ? $request->access_to : null,
            ]);

            $accessPossibility ? $this->possibility->update($request, $accessPossibility->id) :
            $this->possibility->create($request);
        }else{

            if ($accessPossibility)
                $accessPossibility->delete();
        }
        
        if ($request->title_possibility && count($request->title_possibility)) {

            foreach ($request->title_possibility as $key => $value) {

                if ($key != '::index') {
                    $request->merge([
                        'active_possibility_title' => $request->title_possibility[$key],
                        'active_status_possibility' => isset($request->status_possibility[$key]) && $request->status_possibility[$key] ? 1 : 0,
                        'active_possibility_access_to' => isset($request->access_to[$key]) ? $request->access_to[$key] : null,
                    ]);

                    if (($id = array_search($key, $possibilities_ids)) !== false) {
                        unset($possibilities_ids[$id]);
                        $this->possibility->update($request, $key);
                    } else {

                        $this->possibility->create($request);
                    }
                }
            }

            if (count($possibilities_ids))
                $model->possibilities()->whereIn('id', $possibilities_ids)->delete();
        }

        parent::modelUpdated($model, $request);
    }
}

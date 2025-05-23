<?php

namespace Modules\Job\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Core\Traits\DataTable;
use Modules\Job\Transformers\Dashboard\CVSResource;
use Modules\Job\Repositories\Dashboard\CVSRepository as CVS;

class CVSController extends Controller
{
    function __construct(CVS $cvs)
    {
        $this->cvs     = $cvs;
    }

    public function index()
    {
        return view('job::dashboard.cvs.index');
    }

    public function datatable(Request $request)
    {
        $datatable = DataTable::drawTable($request, $this->cvs->QueryTable($request));

        $datatable['data'] = CVSResource::collection($datatable['data']);

        return Response()->json($datatable);
    }

    public function show($cvId,$jobId)
    {
        $cv = $this->cvs->findCvByJobId($cvId,$jobId);
        return view('job::dashboard.cvs.show' , compact('cv','jobId') );
    }

    public function update(Request $request,$id)
    {
        try {
            $update = $this->cvs->update($request,$id);

            if ($update) {
                return Response()->json([true , __('apps::dashboard.messages.updated')]);
            }

            return Response()->json([false  , __('apps::dashboard.messages.failed')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    public function cv($jobId,$userId)
    {
        $cv = $this->cvs->findCvByJobId($jobId,$userId);

        if (is_null($cv))
            abort(404);

        return view('job::dashboard.cvs.cv' , compact('cv') );
    }

}

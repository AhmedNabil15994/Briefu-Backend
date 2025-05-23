<?php

namespace Modules\Course\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Core\Traits\DataTable;
use Modules\Course\Http\Requests\Dashboard\CourseRequest;
use Modules\Course\Transformers\Dashboard\CourseResource;
use Modules\Course\Repositories\Dashboard\CourseRepository as Course;

class CourseController extends Controller
{

    function __construct(Course $course)
    {
        $this->course = $course;
    }

    public function index()
    {
        return view('course::dashboard.index');
    }

    public function datatable(Request $request)
    {
        $datatable = DataTable::drawTable($request, $this->course->QueryTable($request));

        $datatable['data'] = CourseResource::collection($datatable['data']);

        return Response()->json($datatable);
    }

    public function create()
    {
        return view('course::dashboard.create');
    }

    public function store(CourseRequest $request)
    {
        try {
            $create = $this->course->create($request);

            if ($create) {
                return Response()->json([true , __('apps::dashboard.messages.created')]);
            }

            return Response()->json([true , __('apps::dashboard.messages.failed')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    public function show($id)
    {
        return view('course::dashboard.show');
    }

    public function edit($id)
    {
        $course = $this->course->findById($id);

        return view('course::dashboard.edit',compact('course'));
    }

    public function update(CourseRequest $request, $id)
    {
        try {
            $update = $this->course->update($request,$id);

            if ($update) {
                return Response()->json([true , __('apps::dashboard.messages.updated')]);
            }

            return Response()->json([true , __('apps::dashboard.messages.failed')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    public function destroy($id)
    {
        try {
            $delete = $this->course->delete($id);

            if ($delete) {
              return Response()->json([true , __('apps::dashboard.messages.deleted')]);
            }

            return Response()->json([true , __('apps::dashboard.messages.failed')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    public function deletes(Request $request)
    {
        try {
            $deleteSelected = $this->course->deleteSelected($request);

            if ($deleteSelected) {
              return Response()->json([true , __('apps::dashboard.messages.deleted')]);
            }

            return Response()->json([true , __('apps::dashboard.messages.failed')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }
}

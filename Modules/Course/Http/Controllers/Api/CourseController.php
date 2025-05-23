<?php

namespace Modules\Course\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\Course\Transformers\Api\CourseResource;
use Modules\Course\Repositories\Api\CourseRepository as Course;
use Modules\Apps\Http\Controllers\Api\ApiController;

class CourseController extends ApiController
{

    function __construct(Course $course)
    {
        $this->course = $course;
    }

    public function courses(Request $request)
    {
        $courses =  $this->course->getAllActivePaginate($request);

        return CourseResource::collection($courses);
    }

    public function course($id)
    {
        $course = $this->course->findById($id);

        if(!$course)
          return $this->response([]);

        return $this->response(new CourseResource($course));
    }
}

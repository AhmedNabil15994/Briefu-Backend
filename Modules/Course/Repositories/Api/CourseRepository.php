<?php

namespace Modules\Course\Repositories\Api;

use Modules\Course\Entities\Course;

class CourseRepository
{
    function __construct(Course $course)
    {
        $this->course   = $course;
    }

    public function getAllActivePaginate($request,$order = 'id', $sort = 'desc')
    {
        $courses = $this->course->active()->orderBy($order, $sort);

        if (isset($request['categories_ids'])) {

            $courses->whereHas('categories', function($query) use($request) {
                $query->whereIn('categories.id',$request['categories_ids']);
            });
        }

        return $courses->get();
    }

    public function coursesByCategories($ids)
    {
        $courses = $this->course->active()->whereHas('categories', function($query) use($ids) {
            $query->whereIn('categories.id',$ids);
        });
        return $courses->inRandomOrder()->take(10)->get();
    }

    public function findById($id)
    {
        $course = $this->course->active()->where('id',$id)->first();
        return $course;
    }
}

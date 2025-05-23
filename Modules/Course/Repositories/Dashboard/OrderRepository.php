<?php

namespace Modules\Course\Repositories\Dashboard;

use Modules\Course\Entities\Course;
use Modules\Course\Entities\CourseUser;
use Modules\User\Entities\User;
use DB;
use Modules\Attribute\Entities\Attribute;

class OrderRepository
{

    function __construct(CourseUser $course, User $user,Attribute $attribute)
    {
        $this->course       = $course;
        $this->user         = $user;
        $this->attribute    = $attribute;
    }

    public function getAll($order = 'id', $sort = 'desc')
    {
        $course = $this->course->orderBy($order, $sort)->get();
        return $course;
    }

    public function findById($id)
    {
        $course = $this->course->find($id);
        return $course;
    }

    public function findOrderByCourseId($courseId,$userId)
    {
        $cv = $this->user->whereHas('courses', function($query) use ($userId,$courseId){
            $query->where('user_id',$userId)->where('course_id',$courseId);
        })->first();

        return $cv;
    }

    public function QueryTable($request)
    {
        $query = $this->course->with(['user','course'])->where(function($query) use($request){
                $query->where('id' , 'like' , '%'. $request->input('search.value') .'%');

                $query->orWhereHas('user',function($query) use($request){
                    $query->where('name' , 'like' , '%'. $request->input('search.value') .'%');
                    $query->orWhere('mobile' , 'like' , '%'. $request->input('search.value') .'%');
                }); 

                $query->orWhereHas('course', function($query) use ($request){

                    $query->whereHas('translations', function ($query) use ($request) {
                        $query->where('title', 'like', '%' . $request->input('search.value') . '%');
                    });

                    $query->orWhereHas('company', function ($query) use ($request) {
                        $query->whereHas('translations', function ($query) use ($request) {
                            $query->where('title', 'like', '%'.$request->input('search.value').'%');
                        });
                    });
                });
            });

        $company = $this->checkUserCompany();

        if (!empty($company))
            $query->whereHas('course', function($query) use($company) {
                $query->where('company_id',$company->id);
            });


        $query = $this->filterDataTable($query,$request);

        return $query;
    }

    public function filterDataTable($query,$request)
    {
        // Search course by Created Dates
        if (isset($request['req']['from']))
                $query->whereDate('created_at'  , '>=' , $request['req']['from']);

        if (isset($request['req']['to']))
                $query->whereDate('created_at'  , '<=' , $request['req']['to']);

        if (isset($request['req']['companies'])) {

            $query->whereHas('course', function($query) use ($request){
                $query->where('company_id',$request['req']['companies']);
            });

        }

        foreach ($this->attribute->where('is_field',true)->get() as $key => $course) {

            if (isset($request['req']['attribute_values['.$course['id'].''])) {
                $query->whereHas('user.target', function($query) use ($request,$course){
                    $query->where('attribute_value_id',$request['req']['attribute_values['.$course['id'].'']);
                });
            }

        }


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

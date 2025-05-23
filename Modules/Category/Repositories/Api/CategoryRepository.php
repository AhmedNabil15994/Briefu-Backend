<?php

namespace Modules\Category\Repositories\Api;

use Modules\Category\Entities\Category;

class CategoryRepository
{
    function __construct(Category $category)
    {
        $this->category   = $category;
    }

    public function getAllActivePaginate($order = 'id', $sort = 'desc')
    {
        $categories = $this->category->active()->orderBy($order, $sort)->get();
        return $categories;
    }

    public function findById($id)
    {
        $category = $this->category->active()->where('id',$id)->first();
        return $category;
    }
}

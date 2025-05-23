<?php

namespace Modules\Attribute\Repositories\Api;

use Modules\Attribute\Entities\Attribute;

class AttributeRepository
{
    function __construct(Attribute $attribute)
    {
        $this->attribute    = $attribute;
    }

    public function getAll()
    {
        $attributes = $this->attribute->orderBy('id','DESC')->get();
        return $attributes;
    }

    public function getAllTargetList()
    {
        $attributes = $this->attribute->where('is_field',true)->orderBy('id','DESC')->get();
        return $attributes;
    }

}

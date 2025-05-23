<?php

namespace Modules\Attribute\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\Attribute\Transformers\Api\AttributeResource;
use Modules\Attribute\Transformers\Api\TargetResource;
use Modules\Apps\Http\Controllers\Api\ApiController;
use Modules\Attribute\Repositories\Api\AttributeRepository as Attribute;

class AttributeController extends ApiController
{

    function __construct(Attribute $attribute)
    {
        $this->attribute = $attribute;
    }

    public function attributes()
    {
        $attributes =  $this->attribute->getAll();
        return AttributeResource::collection($attributes);
    }

    public function target()
    {
        $target =  $this->attribute->getAllTargetList();
        return TargetResource::collection($target);
    }
}

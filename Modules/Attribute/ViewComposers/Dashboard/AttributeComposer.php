<?php

namespace Modules\Attribute\ViewComposers\Dashboard;

use Modules\Attribute\Repositories\Dashboard\AttributeRepository as Attribute;
use Illuminate\View\View;
use Cache;

class AttributeComposer
{
    public $attributes = [];

    public function __construct(Attribute $attribute)
    {
        $this->attributes =  $attribute->getAll();
    }

    public function compose(View $view)
    {
        $view->with('attributes', $this->attributes);
    }
}

<?php

namespace Modules\Attribute\ViewComposers\Dashboard;

use Modules\Attribute\Repositories\Dashboard\AttributeRepository as Attribute;
use Illuminate\View\View;
use Cache;

class AttributeTargetComposer
{
    public $targets = [];

    public function __construct(Attribute $target)
    {
        $this->targets =  $target->getAllTarget();
    }

    public function compose(View $view)
    {
        $view->with('targets', $this->targets);
    }
}

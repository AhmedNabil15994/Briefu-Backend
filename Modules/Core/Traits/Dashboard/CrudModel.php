<?php

namespace Modules\Core\Traits\Dashboard;

use Modules\Core\Traits\ScopesTrait;

trait CrudModel
{
    use ScopesTrait;
    public $timestamps = true;
    public function getGuardName()
    {
        return $this->guard_name;
    }
}

<?php

namespace Modules\Package\Repositories\Api;

use Modules\Package\Entities\Package;

class PackageRepository
{
    function __construct(Package $package)
    {
        $this->package = $package;
    }

    public function getAllPackages($request)
    {
        $packages = $this->package->active()->orderBy('id','DESC')->get();
        return $packages;
    }
}

<?php

namespace Modules\Package\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\Package\Transformers\Api\PackageResource;
use Modules\Package\Repositories\Api\PackageRepository as Package;
use Modules\Apps\Http\Controllers\Api\ApiController;

class PackageController extends ApiController
{

    function __construct(Package $packages)
    {
        $this->packages = $packages;
    }

    public function packages(Request $request)
    {
        $packages =  $this->packages->getAllCompanies($request);

        return PackageResource::collection($packages);
    }
}

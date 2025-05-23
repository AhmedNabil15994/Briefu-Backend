<?php

namespace Modules\Package\ViewComposers\Dashboard;

use Modules\Package\Repositories\Dashboard\PackageRepository as Package;
use Illuminate\View\View;

class PackageComposer
{
    public $packages = [];

    public function __construct(Package $package)
    {
        $this->packages =  $package->getAll();
    }

    public function compose(View $view)
    {
        $view->with('packages' , $this->packages);
    }
}

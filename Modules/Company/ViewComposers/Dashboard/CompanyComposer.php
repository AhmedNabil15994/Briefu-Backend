<?php

namespace Modules\Company\ViewComposers\Dashboard;

use Modules\Company\Repositories\Dashboard\CompanyRepository as Company;
use Illuminate\View\View;

class CompanyComposer
{
    public $companies = [];

    public function __construct(Company $company)
    {
        $this->companies =  $company->getAll();
    }

    public function compose(View $view)
    {
        $view->with('companies' , $this->companies);
    }
}

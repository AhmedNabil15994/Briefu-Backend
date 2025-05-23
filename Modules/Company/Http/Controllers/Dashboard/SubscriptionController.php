<?php

namespace Modules\Company\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Core\Traits\DataTable;
use Illuminate\Routing\Controller;
use Modules\Company\Http\Requests\Dashboard\CompanyRequest;
use Modules\Company\Transformers\Dashboard\CompanyResource;
use Modules\Company\Repositories\Dashboard\CompanyRepository as Company;
use Modules\Package\Entities\Package;
use Modules\User\Traits\Dashboard\UserCompanyTrait;

class SubscriptionController extends Controller
{
    use UserCompanyTrait;

    function __construct(Company $company)
    {
        $this->company = $company;
    }

    public function index()
    {
        $company = null;
        $data = [];

        $company = auth()->user()->companies()->first();

        if (!empty($company))
            $data['activeSubscription']    = $this->getActiveSubscription();

        return view('company::dashboard.subscriptions.index' , compact('data'));
    }

    public function getLevels($packageId)
    {
        $model = Package::findOrFail($packageId);
        $prices = $model->levels->pluck('price','id')->toArray();
        return response()->json(['html' => view('company::dashboard.subscriptions.components.package-levels-selector',compact('prices'))->render()]);
    }

    public function store(Request $request)
    {
        $company = auth()->user()->companies()->first();

        $create = $this->company->newSubscription($company,$request);

        if ($create)
            return redirect()->back()->with(['msg' => 'Done' , 'alert'=> 'success']);

            return redirect()->back()->with(['msg' => 'Try Again' , 'alert'=> 'danger']);
    }
}

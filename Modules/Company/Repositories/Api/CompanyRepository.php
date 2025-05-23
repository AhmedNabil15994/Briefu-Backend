<?php

namespace Modules\Company\Repositories\Api;

use Modules\Company\Entities\Company;

class CompanyRepository
{
    function __construct(Company $company)
    {
        $this->company = $company;
    }

    public function getAllCompanies($request)
    {
        $companies = $this->company->whereHas('subscriptions', function($query) use($request){

            $query
            ->where('is_paid',true)
            ->where('date_from' , '<=' , date('Y-m-d'))
            ->where(function($query) use($request){
                if($request->type && $request->type == 'special'){

                    $query->where('company_in_home',true);
                }
            })
            ->where(function($query){
                $query->where( 'date_to', '>=', date('Y-m-d') );
                $query->orWhere('date_to', '=', null);
            });

        })->active()->orderBy('id','DESC')->get();

        return $companies;
    }
}

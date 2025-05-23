<?php

namespace Modules\User\Traits\Dashboard;

trait UserCompanyTrait
{
    public function getSubscriptions()
    {
        $company = self::getCompany();

        if (is_null($company))
            return null;

        return $subscriptions = $company->subscriptions;
    }

    public function getActiveSubscription()
    {
        $company = self::getCompany();

        if (is_null($company))
            return null;

        return $subscriptions = $company->activeSubscription();
    }

    public function getUpcomingSubscriptions()
    {
        $company = self::getCompany();

        if (is_null($company))
            return null;

        return $subscriptions = $company->upcomingSubscriptions();
    }

    public function getSubscriptionsHistory()
    {
        $company = self::getCompany();

        if (is_null($company))
            return null;

        return $subscriptions = $company->historyOfSubscriptions();
    }

    static public function getCompany()
    {
        $company = auth()->user()->companies()->first();

        if (empty($company))
            return null;

        return $company;
    }

}

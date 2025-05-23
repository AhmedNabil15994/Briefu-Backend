<?php

namespace Modules\Package\Traits;

use Modules\Package\Entities\Package;
use Modules\Package\Entities\PackageLevel;

trait SubscriptionCalculations
{
    public function packageLevels($data)
    {
        $package = $this->findPackage($data);

        $data = [];

        $lastDate = date('Y-m-d');

        foreach ($package->levels as $key => $level) {

            $dates = $this->getDates($level['months'],$lastDate);

            $data['date_from']          = $dates['date_from'];
            $data['date_to']            = $dates['date_to'];
            $data['job_posts']          = $level['job_posts'];
            $data['sort']               = $level['sort'];
            $data['months']             = $level['months'];
            $data['price']              = $level['price'];
            $data['video_cv']           = $level['video_cv'];
            $data['company_in_home']    = $level['company_in_home'];
            $data['package_id']         = $package['id'];

            $levelsOfPackage[] = $data;


            $lastDate = $dates['date_to'];
        }


        return $levelsOfPackage;
    }
    public function packageLevelById($levelId)
    {
        $level = PackageLevel::findOrFail($levelId);
        
        $data = [];

        $lastDate = date('Y-m-d');
        
        $dates = $this->getDates($level['months'],$lastDate);

        $data['date_from']          = $dates['date_from'];
        $data['date_to']            = $dates['date_to'];
        $data['job_posts']          = $level['job_posts'];
        $data['sort']               = $level['sort'];
        $data['months']             = $level['months'];
        $data['price']              = $level['price'];
        $data['video_cv']           = $level['video_cv'];
        $data['company_in_home']    = $level['company_in_home'];
        $data['package_id']         = $level['package_id'];
        $data['level_id']         = $level['id'];

        return $data;
    }

    public function getDates($months,$lastDate)
    {
        $dates['date_from']   =  $lastDate;
        $dates['date_to']     =  is_null($months) ? null : date('Y-m-d', strtotime("+".$months." months", strtotime($lastDate)));

        return $dates;
    }

    public function findPackage($data)
    {
        return Package::find($data['package']);
    }
}

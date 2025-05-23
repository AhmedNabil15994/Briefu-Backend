<?php

namespace Modules\Job\ViewComposers\Dashboard;

use Modules\Job\Repositories\Dashboard\JobRepository as Job;
use Illuminate\View\View;
use Cache;

class JobComposer
{
    public $jobs = [];

    public function __construct(Job $job)
    {
        $this->jobs =  $job->getAll();
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('jobs' , $this->jobs);
    }
}

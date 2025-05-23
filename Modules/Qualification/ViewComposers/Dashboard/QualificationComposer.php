<?php

namespace Modules\Qualification\ViewComposers\Dashboard;

use Modules\Qualification\Repositories\Dashboard\QualificationRepository as Qualification;
use Illuminate\View\View;
use Cache;

class QualificationComposer
{
    public $qualifications = [];

    public function __construct(Qualification $qualification)
    {
        $this->qualifications =  $qualification->getAllActive();
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('qualifications' , $this->qualifications);
    }
}

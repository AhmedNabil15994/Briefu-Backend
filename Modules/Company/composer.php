<?php

// Dashboard ViewComposr
view()->composer([
    'job::dashboard.jobs.*',
    'course::dashboard.*',
    'job::dashboard.cvs.index',
    'report::dashboard.subscriptions.index',
], \Modules\Company\ViewComposers\Dashboard\CompanyComposer::class);

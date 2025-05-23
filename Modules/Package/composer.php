<?php

// Dashboard ViewComposr
view()->composer([
    'company::dashboard.companies.*',
    'company::dashboard.subscriptions.index',
    'report::dashboard.subscriptions.index',
], \Modules\Package\ViewComposers\Dashboard\PackageComposer::class);

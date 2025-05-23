<?php

// Dashboard ViewComposr
view()->composer([
    'course::dashboard.create',
    'course::dashboard.edit',
    'category::dashboard.categories.*',
    'job::dashboard.jobs.*',
], \Modules\Category\ViewComposers\Dashboard\CategoryComposer::class);

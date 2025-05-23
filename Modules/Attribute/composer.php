<?php

view()->composer([
  'job::dashboard.jobs.*',
  'job::dashboard.cvs.index',
  'report::dashboard.users.index'
], \Modules\Attribute\ViewComposers\Dashboard\AttributeComposer::class);


view()->composer([
    'job::dashboard.cvs.index',
    'job::dashboard.jobs.show',
    'course::dashboard.order.index',
], \Modules\Attribute\ViewComposers\Dashboard\AttributeTargetComposer::class);

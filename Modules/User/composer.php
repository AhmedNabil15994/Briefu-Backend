<?php

// Dashboard ViewComposr
view()->composer([
  'company::dashboard.companies.index',
  'company::dashboard.companies.create',
], \Modules\User\ViewComposers\Dashboard\UserComposer::class);

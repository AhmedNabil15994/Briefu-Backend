<?php

view()->composer(['user::dashboard.admins.index'], \Modules\Authorization\ViewComposers\Dashboard\AdminRolesComposer::class);


view()->composer([
  'user::dashboard.owners.index',
], \Modules\Authorization\ViewComposers\Dashboard\CompanyOwnerRolesComposer::class);

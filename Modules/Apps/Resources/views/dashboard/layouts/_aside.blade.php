<div class="page-sidebar-wrapper">

    <div class="page-sidebar navbar-collapse collapse">
        <ul class="page-sidebar-menu  page-header-fixed"
            data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200" style="padding-top: 20px">

            <li class="sidebar-toggler-wrapper hide">
                <div class="sidebar-toggler">
                    <span></span>
                </div>
            </li>

            <li class="nav-item {{ active_menu('home') }}">
                <a href="{{ url(route('dashboard.home')) }}" class="nav-link nav-toggle">
                    <i class="icon-home"></i>
                    <span class="title">{{ __('apps::dashboard.index.title') }}</span>
                    <span class="selected"></span>
                </a>
            </li>

            @permission('company_dashboard_access')

            @permission('show_jobs')
            <li class="nav-item {{ active_menu('jobs') }}">
                <a href="{{ url(route('dashboard.jobs.index')) }}" class="nav-link nav-toggle">
                    <i class="icon-settings"></i>
                    <span class="title">{{ __('apps::dashboard._layout.aside.jobs') }}</span>
                </a>
            </li>
            @endpermission

            @permission('show_courses')
            <li class="nav-item {{ active_menu('courses') }}">
                <a href="{{ url(route('dashboard.courses.index')) }}" class="nav-link nav-toggle">
                    <i class="icon-settings"></i>
                    <span class="title">{{ __('apps::dashboard._layout.aside.courses') }}</span>
                </a>
            </li>
            @endpermission

            @permission('show_subscriptions')
            <li class="nav-item {{ active_menu('subscriptions') }}">
                <a href="{{ url(route('dashboard.subscriptions.index')) }}" class="nav-link nav-toggle">
                    <i class="icon-settings"></i>
                    <span class="title">{{ __('apps::dashboard._layout.aside.subscriptions') }}</span>
                </a>
            </li>
            @endpermission

            @permission('show_course_orders')
            <li class="nav-item {{ active_menu('course_orders') }}">
                <a href="{{ url(route('dashboard.course_orders.index')) }}" class="nav-link nav-toggle">
                    <i class="icon-settings"></i>
                    <span class="title">{{ __('apps::dashboard._layout.aside.course_orders') }}</span>
                </a>
            </li>
            @endpermission

            @endpermission

            @permission('dashboard_access')

            <li class="heading">
                <h3 class="uppercase">{{ __('apps::dashboard._layout.aside._tabs.users') }}</h3>
            </li>
            @permission('show_roles')
            <li class="nav-item {{ active_menu('roles') }}">
                <a href="{{ url(route('dashboard.roles.index')) }}" class="nav-link nav-toggle">
                    <i class="icon-settings"></i>
                    <span class="title">{{ __('apps::dashboard._layout.aside.roles') }}</span>
                </a>
            </li>
            @endpermission
            @permission('show_users')
            <li class="nav-item {{ active_menu('users') }}">
                <a href="{{ url(route('dashboard.users.index')) }}" class="nav-link nav-toggle">
                    <i class="icon-settings"></i>
                    <span class="title">{{ __('apps::dashboard._layout.aside.users') }}</span>
                </a>
            </li>
            @endpermission

            @permission('show_admins')
            <li class="nav-item {{ active_menu('admins') }}">
                <a href="{{ url(route('dashboard.admins.index')) }}" class="nav-link nav-toggle">
                    <i class="icon-settings"></i>
                    <span class="title">{{ __('apps::dashboard._layout.aside.admins') }}</span>
                </a>
            </li>
            @endpermission

            @permission('show_company_owners')
            <li class="nav-item {{ active_menu('company_owners') }}">
                <a href="{{ url(route('dashboard.company_owners.index')) }}" class="nav-link nav-toggle">
                    <i class="icon-settings"></i>
                    <span class="title">{{ __('apps::dashboard._layout.aside.company_owners') }}</span>
                </a>
            </li>
            @endpermission

            <li class="heading">
                <h3 class="uppercase">{{ __('apps::dashboard._layout.aside._tabs.jobs') }}</h3>
            </li>

            @permission('show_jobs')
            <li class="nav-item {{ active_menu('jobs') }}">
                <a href="{{ url(route('dashboard.jobs.index')) }}" class="nav-link nav-toggle">
                    <i class="icon-settings"></i>
                    <span class="title">{{ __('apps::dashboard._layout.aside.jobs') }}</span>
                </a>
            </li>
            @endpermission

            @permission('show_companies')
            <li class="nav-item {{ active_menu('companies') }}">
                <a href="{{ url(route('dashboard.companies.index')) }}" class="nav-link nav-toggle">
                    <i class="icon-settings"></i>
                    <span class="title">{{ __('apps::dashboard._layout.aside.companies') }}</span>
                </a>
            </li>
            @endpermission

            @permission('show_client_subscriptions')
            <li class="nav-item {{ active_menu('client-subscriptions') }}">
                <a href="{{ url(route('dashboard.client-subscriptions.index')) }}" class="nav-link nav-toggle">
                    <i class="icon-settings"></i>
                    <span class="title">{{ __('apps::dashboard._layout.aside.client_subscriptions') }}</span>
                </a>
            </li>
            @endpermission

            @permission('show_attributes')

            <li class="nav-item  {{active_slide_menu(['attributes'])}}">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon-settings"></i>
                    <span class="title">{{ __('apps::dashboard._layout.aside.attributes') }}</span>
                    <span class="arrow {{active_slide_menu(['attributes'])}}"></span>
                    <span class="selected"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item {{ active_menu('attributes') }}">
                        <a href="{{ url(route('dashboard.attributes.index')) }}" class="nav-link nav-toggle">
                            <i class="icon-settings"></i>
                            <span class="title">{{ __('apps::dashboard._layout.aside.attributes') }}</span>
                        </a>
                    </li>
                    @inject('attributes','Modules\Attribute\Entities\Attribute')

                    @if($attributes->count())
                        @foreach($attributes->all() as $attribute)
                            <li class="nav-item">
                                <a href="{{ route('dashboard.attributes.edit', $attribute->id) }}"
                                   class="nav-link nav-toggle">
                                    <i class="icon-settings"></i>
                                    <span class="title">{{$attribute->translate(locale())->title}}</span>
                                    <span class="selected"></span>
                                </a>
                            </li>
                        @endforeach
                    @endif
                    @permission('show_qualifications')
                    <li class="nav-item {{ active_menu('qualifications') }}">
                        <a href="{{ url(route('dashboard.qualifications.index')) }}" class="nav-link nav-toggle">
                            <i class="icon-settings"></i>
                            <span class="title">{{ __('apps::dashboard._layout.aside.qualifications') }}</span>
                        </a>
                    </li>
                    @endpermission
                </ul>
            </li>

            @endpermission

            <li class="heading">
                <h3 class="uppercase">{{ __('apps::dashboard._layout.aside._tabs.courses') }}</h3>
            </li>
            @permission('show_categories')
            <li class="nav-item {{ active_menu('categories') }}">
                <a href="{{ url(route('dashboard.categories.index')) }}" class="nav-link nav-toggle">
                    <i class="icon-settings"></i>
                    <span class="title">{{ __('apps::dashboard._layout.aside.categories') }}</span>
                </a>
            </li>
            @endpermission

            @permission('show_courses')
            <li class="nav-item {{ active_menu('courses') }}">
                <a href="{{ url(route('dashboard.courses.index')) }}" class="nav-link nav-toggle">
                    <i class="icon-settings"></i>
                    <span class="title">{{ __('apps::dashboard._layout.aside.courses') }}</span>
                </a>
            </li>
            @endpermission

            @permission('show_course_orders')
            <li class="nav-item {{ active_menu('course_orders') }}">
                <a href="{{ url(route('dashboard.course_orders.index')) }}" class="nav-link nav-toggle">
                    <i class="icon-settings"></i>
                    <span class="title">{{ __('apps::dashboard._layout.aside.course_orders') }}</span>
                </a>
            </li>
            @endpermission

            <li class="heading">
                <h3 class="uppercase">{{ __('apps::dashboard._layout.aside._tabs.subscriptions') }}</h3>
            </li>

            @permission('show_reports')
            <li class="nav-item {{ active_menu('reports/subscriptions') }}">
                <a href="{{ url(route('dashboard.reports.subscriptions.index')) }}" class="nav-link nav-toggle">
                    <i class="icon-settings"></i>
                    <span class="title">{{ __('apps::dashboard._layout.aside.subscriptions_reports') }}</span>
                </a>
            </li>
            <li class="nav-item {{ active_menu('reports/client-subscription') }}">
                <a href="{{ url(route('dashboard.reports.client.subscriptions.index')) }}" class="nav-link nav-toggle">
                    <i class="icon-settings"></i>
                    <span class="title">{{ __('apps::dashboard._layout.aside.client_subscription_report') }}</span>
                </a>
            </li>
            @endpermission

            @permission('show_consultations_reports')
            
            <li class="nav-item {{ active_menu('reports/consultations') }}">
                <a href="{{ url(route('dashboard.reports.consultations.index')) }}" class="nav-link nav-toggle">
                    <i class="icon-settings"></i>
                    <span class="title">{{ __('apps::dashboard._layout.aside.consultations_report') }}</span>
                </a>
            </li>
            @endpermission

            @permission('show_reports')
            <li class="nav-item {{ active_menu('reports/users') }}">
                <a href="{{ url(route('dashboard.reports.users.index')) }}" class="nav-link nav-toggle">
                    <i class="icon-settings"></i>
                    <span class="title">{{ __('apps::dashboard._layout.aside.users_report') }}</span>
                </a>
            </li>
            @endpermission

            @permission('show_packages')
            <li class="nav-item {{ active_menu('packages') }}">
                <a href="{{ url(route('dashboard.packages.index')) }}" class="nav-link nav-toggle">
                    <i class="icon-settings"></i>
                    <span class="title">{{ __('apps::dashboard._layout.aside.packages') }}</span>
                </a>
            </li>
            @endpermission

            <li class="heading">
                <h3 class="uppercase">{{ __('apps::dashboard._layout.aside._tabs.other') }}</h3>
            </li>

            @permission('show_notifications')
            <li class="nav-item {{ active_menu('notifications') }}">
                <a href="{{ url(route('dashboard.notifications.index')) }}" class="nav-link nav-toggle">
                    <i class="icon-settings"></i>
                    <span class="title">{{ __('apps::dashboard._layout.aside.notifications') }}</span>
                </a>
            </li>
            @endpermission

            @permission('show_pages')
            <li class="nav-item {{ active_menu('pages') }}">
                <a href="{{ url(route('dashboard.pages.index')) }}" class="nav-link nav-toggle">
                    <i class="icon-settings"></i>
                    <span class="title">{{ __('apps::dashboard._layout.aside.pages') }}</span>
                </a>
            </li>
            @endpermission

            @permission('show_coupons')
            <li class="nav-item {{ active_menu('coupons') }}">
                <a href="{{ url(route('dashboard.coupons.index')) }}" class="nav-link nav-toggle">
                    <i class="icon-settings"></i>
                    <span class="title">{{ __('apps::dashboard._layout.aside.coupons') }}</span>
                </a>
            </li>
            @endpermission

            @permission('show_nationalities')
            <li class="nav-item {{ active_menu('nationalities') }}">
                <a href="{{ url(route('dashboard.nationalities.index')) }}" class="nav-link nav-toggle">
                    <i class="icon-settings"></i>
                    <span class="title">{{ __('apps::dashboard._layout.aside.nationalities') }}</span>
                </a>
            </li>
            @endpermission


            <li class="nav-item  {{active_slide_menu(['countries','cities','states'])}}">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon-pointer"></i>
                    <span class="title">{{ __('apps::dashboard._layout.aside.countries') }}</span>
                    <span class="arrow {{active_slide_menu(['countries','governorates','cities','regions'])}}"></span>
                    <span class="selected"></span>
                </a>
                <ul class="sub-menu">
                    @permission('show_countries')
                    <li class="nav-item {{ active_menu('countries') }}">
                        <a href="{{ url(route('dashboard.countries.index')) }}" class="nav-link nav-toggle">
                            <i class="icon-settings"></i>
                            <span class="title">{{ __('apps::dashboard._layout.aside.countries') }}</span>
                            <span class="selected"></span>
                        </a>
                    </li>
                    @endpermission

                    @permission('show_cities')
                    <li class="nav-item {{ active_menu('cities') }}">
                        <a href="{{ url(route('dashboard.cities.index')) }}" class="nav-link nav-toggle">
                            <i class="icon-settings"></i>
                            <span class="title">{{ __('apps::dashboard._layout.aside.cities') }}</span>
                            <span class="selected"></span>
                        </a>
                    </li>
                    @endpermission

                    @permission('show_states')
                    <li class="nav-item {{ active_menu('states') }}">
                        <a href="{{ url(route('dashboard.states.index')) }}" class="nav-link nav-toggle">
                            <i class="icon-settings"></i>
                            <span class="title">{{ __('apps::dashboard._layout.aside.states') }}</span>
                            <span class="selected"></span>
                        </a>
                    </li>
                    @endpermission
                </ul>
            </li>


            @permission('edit_settings')
            <li class="nav-item {{ active_menu('setting') }}">
                <a href="{{ url(route('dashboard.setting.index')) }}" class="nav-link nav-toggle">
                    <i class="icon-settings"></i>
                    <span class="title">{{ __('apps::dashboard._layout.aside.setting') }}</span>
                </a>
            </li>
            @endpermission

            @permission('show_telescope')
            <li class="nav-item {{ active_menu('telescope') }}">
                <a href="{{ url(route('telescope')) }}" class="nav-link nav-toggle">
                    <i class="icon-settings"></i>
                    <span class="title">{{ __('apps::dashboard._layout.aside.telescope') }}</span>
                </a>
            </li>
            @endpermission

            @endpermission

        </ul>
    </div>

</div>

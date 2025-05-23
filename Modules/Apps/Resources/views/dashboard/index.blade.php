@extends('apps::dashboard.layouts.app')
@section('title', __('apps::dashboard.index.title'))
@push('styles')
<style>

        .show-print, .show-print *
        {
            display: none !important;
        }
    @media print
    {    
        .no-print, .no-print *
        {
            display: none !important;
        }
        .show-print, .show-print *
        {
            display: block !important;
        }
    }
</style>
@endpush
@section('content')

    <div class="page-content-wrapper">
        <div class="page-content">

            <div class="page-bar no-print">
                <ul class="page-breadcrumb">
                    <li>
                        <a href="{{ url(route('dashboard.home')) }}">
                            {{ __('apps::dashboard.index.title') }}
                        </a>
                    </li>
                </ul>
            </div>

            <h1 class="page-title no-print"> {{ __('apps::dashboard.index.welcome') }} ,
                <small>
                    <b style="color:red">{{ auth()->check() ? auth()->user()->name : '' }} </b>

                    @permission('company_dashboard_access')
                    , ( <b>{{ optional(optional($company)->translate(locale()))->title }} </b> )
                    @endpermission
                </small>
            </h1>
            <button class="btn btn-primary no-print" onclick="window.print();" style="margin-bottom: 11px;"> @lang("apps::dashboard.buttons.print")</button>
            <br>

            @permission('company_dashboard_access')
            <div class="row">

                <div class="col-lg-12 col-xs-12 col-sm-12">

                    @if (!empty($data['activeSubscription']))

                        <div class="portlet light ">
                            <div class="portlet-title tabbable-line">
                                <ul class="nav nav-tabs">

                                    <li class="active">
                                        <a href="#portlet_comments_3"
                                           data-toggle="tab"> {{ __('apps::dashboard.index.active_subscription') }} </a>
                                    </li>

                                    <li class="">
                                        <a href="#portlet_comments_1"
                                           data-toggle="tab"> {{ __('apps::dashboard.index.history') }} </a>
                                    </li>
                                    <li>
                                        <a href="#portlet_comments_2"
                                           data-toggle="tab"> {{ __('apps::dashboard.index.upcoming') }} </a>
                                    </li>
                                </ul>
                            </div>

                            <div class="portlet-body">
                                <div class="tab-content">
                                    <div class="tab-pane" id="portlet_comments_1">
                                        <!-- BEGIN: Comments -->
                                        <div class="mt-comments">

                                            @foreach ($data['subscriptionsHistory'] as $key => $history)

                                                <div class="mt-comment">

                                                    <div class="mt-comment-img">
                                                        <i class="fa fa-hourglass-end" aria-hidden="true"></i>
                                                    </div>

                                                    <div class="mt-comment-body">
                                                        <div class="mt-comment-info">
                                                        <span class="mt-comment-author">
                                                            {{ optional(optional($history->package)->translate(locale()))->title }}
                                                        </span>
                                                            <span class="mt-comment-date">
                                                            <h4>{{ $history->date_from }} / {{ $history->date_to }}</h4>
                                                        </span>
                                                        </div>
                                                        <div class="mt-comment-text">
                                                            <div class="table-scrollable table-scrollable-borderless">
                                                                <table class="table table-hover table-light">
                                                                    <thead>
                                                                    <tr class="uppercase">
                                                                        <th colspan="2">
                                                                            {{ __('apps::dashboard.index.price') }}
                                                                        </th>
                                                                        <th colspan="2">
                                                                            {{ __('apps::dashboard.index.jobs_limit') }}
                                                                        </th>
                                                                        <th colspan="2">
                                                                            {{ __('apps::dashboard.index.months') }}
                                                                        </th>
                                                                        <th colspan="2">
                                                                            {{ __('apps::dashboard.index.video_cv') }}
                                                                        </th>
                                                                        <th colspan="2">
                                                                            {{ __('apps::dashboard.index.company_in_home') }}
                                                                        </th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody>

                                                                    <tr>
                                                                        <td colspan="2"> {{ $history->price }} KWD</td>
                                                                        <td colspan="2"> {{ $history->months }} </td>
                                                                        <td colspan="2"> {{ $history->job_posts }} </td>
                                                                        <td colspan="2">
                                                                            {{ $history->video_cv ? __('apps::dashboard.datatable.active') : __('apps::dashboard.datatable.unactive') }}
                                                                        </td>
                                                                        <td colspan="2"> {{ $history->company_in_home ? __('apps::dashboard.datatable.active') : __('apps::dashboard.datatable.unactive') }}</td>
                                                                    </tr>

                                                                    </tbody>
                                                                </table>
                                                            </div>

                                                        </div>

                                                    </div>
                                                </div>

                                            @endforeach

                                        </div>
                                        <!-- END: Comments -->
                                    </div>

                                    <div class="tab-pane" id="portlet_comments_2">
                                        <!-- BEGIN: Comments -->
                                        <div class="mt-comments">

                                            @foreach ($data['upcomingSubscriptions'] as $key => $upcoming)

                                                <div class="mt-comment">

                                                    <div class="mt-comment-img">
                                                        <i class="fa fa-clock-o" aria-hidden="true"></i>
                                                    </div>

                                                    <div class="mt-comment-body">
                                                        <div class="mt-comment-info">
                                                            <span class="mt-comment-author">
                                                                {{ optional(optional($upcoming->package)->translate(locale()))->title }}
                                                            </span>
                                                            <span class="mt-comment-date">
                                                                <h4>{{ $upcoming->date_from }} / {{ $upcoming->date_to }}</h4>
                                                            </span>
                                                        </div>
                                                        <div class="mt-comment-text">
                                                            <div class="table-scrollable table-scrollable-borderless">
                                                                <table class="table table-hover table-light">
                                                                    <thead>
                                                                    <tr class="uppercase">
                                                                        <th colspan="2">
                                                                            {{ __('apps::dashboard.index.price') }}
                                                                        </th>
                                                                        <th colspan="2">
                                                                            {{ __('apps::dashboard.index.jobs_limit') }}
                                                                        </th>
                                                                        <th colspan="2">
                                                                            {{ __('apps::dashboard.index.months') }}
                                                                        </th>
                                                                        <th colspan="2">
                                                                            {{ __('apps::dashboard.index.video_cv') }}
                                                                        </th>
                                                                        <th colspan="2">
                                                                            {{ __('apps::dashboard.index.company_in_home') }}
                                                                        </th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody>

                                                                    <tr>
                                                                        <td colspan="2"> {{ $upcoming->price }} KWD</td>
                                                                        <td colspan="2"> {{ $upcoming->months }} </td>
                                                                        <td colspan="2"> {{ $upcoming->job_posts }} </td>
                                                                        <td colspan="2">
                                                                            {{ $upcoming->video_cv ? __('apps::dashboard.datatable.active') : __('apps::dashboard.datatable.unactive') }}
                                                                        </td>
                                                                        <td colspan="2"> {{ $upcoming->company_in_home ? __('apps::dashboard.datatable.active') : __('apps::dashboard.datatable.unactive') }}</td>
                                                                    </tr>

                                                                    </tbody>
                                                                </table>
                                                            </div>

                                                        </div>

                                                    </div>
                                                </div>

                                            @endforeach

                                        </div>
                                        <!-- END: Comments -->
                                    </div>

                                    <div class="tab-pane active" id="portlet_comments_3">
                                        <!-- BEGIN: Comments -->
                                        <div class="mt-comments">

                                            @if (!empty($data['activeSubscription']))

                                                <div class="mt-comment">

                                                    <div class="mt-comment-img">
                                                        <i class="fa fa-check" aria-hidden="true"></i>
                                                    </div>

                                                    <div class="mt-comment-body">
                                                        <div class="mt-comment-info">
                                                        <span class="mt-comment-author">
                                                            {{ optional(optional($data['activeSubscription']->package)->translate(locale()))->title }}
                                                        </span>
                                                            <span class="mt-comment-date">
                                                            <h4>{{ $data['activeSubscription']->date_from }} / {{ $data['activeSubscription']->date_to }}</h4>
                                                        </span>
                                                        </div>
                                                        <div class="mt-comment-text">
                                                            <div class="table-scrollable table-scrollable-borderless">
                                                                <table class="table table-hover table-light">
                                                                    <thead>
                                                                    <tr class="uppercase">
                                                                        <th colspan="2">
                                                                            {{ __('apps::dashboard.index.price') }}
                                                                        </th>
                                                                        <th colspan="2">
                                                                            {{ __('apps::dashboard.index.jobs_limit') }}
                                                                        </th>
                                                                        <th colspan="2">
                                                                            {{ __('apps::dashboard.index.months') }}
                                                                        </th>
                                                                        <th colspan="2">
                                                                            {{ __('apps::dashboard.index.video_cv') }}
                                                                        </th>
                                                                        <th colspan="2">
                                                                            {{ __('apps::dashboard.index.company_in_home') }}
                                                                        </th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody>

                                                                    <tr>
                                                                        <td colspan="2"> {{ $data['activeSubscription']->price }}
                                                                            KWD
                                                                        </td>
                                                                        <td colspan="2"> {{ $data['activeSubscription']->months }} </td>
                                                                        <td colspan="2"> {{ $data['activeSubscription']->job_posts }} </td>
                                                                        <td colspan="2">
                                                                            {{ $data['activeSubscription']->video_cv ? __('apps::dashboard.datatable.active') : __('apps::dashboard.datatable.unactive') }}
                                                                        </td>
                                                                        <td colspan="2"> {{ $data['activeSubscription']->company_in_home ? __('apps::dashboard.datatable.active') : __('apps::dashboard.datatable.unactive') }}</td>
                                                                    </tr>

                                                                    </tbody>
                                                                </table>
                                                            </div>

                                                        </div>

                                                    </div>
                                                </div>

                                            @endif

                                        </div>
                                        <!-- END: Comments -->
                                    </div>
                                </div>
                            </div>
                        </div>

                    @else

                        <center>
                            <div class="alert alert-danger">
                                <strong>{{ __('apps::dashboard.index.not_subscribe') }}!</strong> .
                            </div>
                        </center>

                    @endif

                </div>
            </div>
            @endpermission


            @permission('show_statistics')
            @permission('dashboard_access')
            <div class="portlet light bordered no-print">
                <div class="portlet-title tabbable-line">
                    <div class="caption">
                        <i class="icon-bubbles font-dark hide"></i>
                        <span class="caption-subject font-dark bold uppercase">
                                {{__('apps::dashboard.datatable.form.date_range')}}
                            </span>
                    </div>
                </div>
                <div class="portlet-body">
                    <div id="filter_data_table">
                        <div class="panel-body">
                            <form class="horizontal-form">
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-md-9">
                                            <div class="form-group">
                                                <div id="reportrange" class="btn default form-control">
                                                    <i class="fa fa-calendar"></i> &nbsp;
                                                    <span> </span>
                                                    <b class="fa fa-angle-down"></b>
                                                    <input type="hidden" name="from">
                                                    <input type="hidden" name="to">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-actions col-md-3">

                                            <button class="btn btn-sm green btn-outline filter-submit margin-bottom"
                                                    type="submit">
                                                <i class="fa fa-search"></i>
                                                {{__('apps::dashboard.datatable.search')}}
                                            </button>
                                            <a class="btn btn-sm red btn-outline filter-cancel"
                                               href="{{url(route('dashboard.home'))}}">
                                                <i class="fa fa-times"></i>
                                                {{__('apps::dashboard.datatable.reset')}}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="portlet light bordered col-lg-12">
                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12" style="margin-bottom: 20px;">
                        <a class="dashboard-stat dashboard-stat-v2 blue no-print"
                           href="{{route('dashboard.users.index')}}">

                            <div class="visual">
                                <i class="fa fa-clients"></i>
                            </div>
                            <div class="details">
                                <div class="number">
                                    <span data-counter="counterup" data-value="{{$users_count}}">0</span>
                                </div>
                                <div class="desc">{{ __('apps::dashboard._layout.aside.users') }}</div>
                            </div>
                        </a>
                        <div  class="dashboard-stat dashboard-stat-v2 red show-print">
                            <div class="visual">
                                <i class="fa fa-clients"></i>
                            </div>
                            <div class="details">
                                <div class="number">
                                    <span data-counter="counterup" data-value="{{$users_count}}">0</span>
                                </div>
                                <div class="desc">{{ __('apps::dashboard._layout.aside.users') }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12" style="margin-bottom: 20px;">
                        <a class="dashboard-stat dashboard-stat-v2 light no-print"
                           href="{{route('dashboard.company_owners.index')}}">

                            <div class="visual">
                                <i class="icon-layers"></i>
                            </div>
                            <div class="details">
                                <div class="number">
                                    <span data-counter="counterup" data-value="{{$companies_count}}">0</span>
                                </div>
                                <div class="desc">{{ __('apps::dashboard._layout.aside.company_owners') }}</div>
                            </div>
                        </a>
                        <div class="dashboard-stat dashboard-stat-v2 red show-print">
                            <div class="visual">
                                <i class="icon-layers"></i>
                            </div>
                            <div class="details">
                                <div class="number">
                                    <span data-counter="counterup" data-value="{{$companies_count}}">0</span>
                                </div>
                                <div class="desc">{{ __('apps::dashboard._layout.aside.company_owners') }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12" style="margin-bottom: 20px;">
                        <a class="dashboard-stat dashboard-stat-v2 red no-print"
                           href="{{route('dashboard.companies.index')}}">

                            <div class="visual">
                                <i class="fa fa-share"></i>
                            </div>
                            <div class="details">
                                <div class="number">
                                    <span data-counter="counterup" data-value="{{$all_companies_count}}">0</span>
                                </div>
                                <div class="desc">{{ __('apps::dashboard._layout.aside.companies') }}</div>
                            </div>
                        </a>
                        <div class="dashboard-stat dashboard-stat-v2 red show-print">

                            <div class="visual">
                                <i class="fa fa-share"></i>
                            </div>
                            <div class="details">
                                <div class="number">
                                    <span data-counter="counterup" data-value="{{$all_companies_count}}">0</span>
                                </div>
                                <div class="desc">{{ __('apps::dashboard._layout.aside.companies') }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12" style="margin-bottom: 20px;">
                        <a class="dashboard-stat dashboard-stat-v2 orange no-print"
                           href="{{route('dashboard.packages.index')}}">
                            <div class="visual">
                                <i class="icon-docs"></i>
                            </div>
                            <div class="details">
                                <div class="number">
                                    <span data-counter="counterup" data-value="{{$packages}}">0</span>
                                </div>
                                <div class="desc">{{ __('apps::dashboard._layout.aside.packages') }}</div>
                            </div>
                        </a>
                        <div class="dashboard-stat dashboard-stat-v2 red show-print">
                            <div class="visual">
                                <i class="icon-docs"></i>
                            </div>
                            <div class="details">
                                <div class="number">
                                    <span data-counter="counterup" data-value="{{$packages}}">0</span>
                                </div>
                                <div class="desc">{{ __('apps::dashboard._layout.aside.packages') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row widget-row">
                <div class="col-md-3">
                    <!-- BEGIN WIDGET THUMB -->
                    <a href="{{route('dashboard.courses.index')}}" class="no-print">
                        <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 bordered">
                            <h4 class="widget-thumb-heading">{{ __('apps::dashboard._layout.aside.courses') }}</h4>
                            <div class="widget-thumb-wrap">
                                <i class="widget-thumb-icon bg-green icon-bulb"></i>
                                <div class="widget-thumb-body">
                                    <span class="widget-thumb-body-stat" data-counter="counterup"
                                          data-value="{{$courses}}">0</span>
                                </div>
                            </div>
                        </div>
                    </a>
                    <a  class="show-print">
                        <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 bordered">
                            <h4 class="widget-thumb-heading">{{ __('apps::dashboard._layout.aside.courses') }}</h4>
                            <div class="widget-thumb-wrap">
                                <i class="widget-thumb-icon bg-green icon-bulb"></i>
                                <div class="widget-thumb-body">
                                    <span class="widget-thumb-body-stat" data-counter="counterup"
                                          data-value="{{$courses}}">0</span>
                                </div>
                            </div>
                        </div>
                    </a>
                    <!-- END WIDGET THUMB -->
                </div>
                <div class="col-md-3">
                    <!-- BEGIN WIDGET THUMB -->
                    <a href="{{route('dashboard.course_orders.index')}}" class="no-print">
                        <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 bordered">
                            <h4 class="widget-thumb-heading">{{ __('apps::dashboard._layout.aside.course_orders') }}</h4>
                            <div class="widget-thumb-wrap">
                                <i class="widget-thumb-icon bg-red icon-question"></i>
                                <div class="widget-thumb-body">
                                    <span class="widget-thumb-body-stat" data-counter="counterup"
                                          data-value="{{$courseUsers}}">0</span>
                                </div>
                            </div>
                        </div>
                    </a>
                    <a  class="show-print">
                        <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 bordered">
                            <h4 class="widget-thumb-heading">{{ __('apps::dashboard._layout.aside.course_orders') }}</h4>
                            <div class="widget-thumb-wrap">
                                <i class="widget-thumb-icon bg-red icon-question"></i>
                                <div class="widget-thumb-body">
                                    <span class="widget-thumb-body-stat" data-counter="counterup"
                                          data-value="{{$courseUsers}}">0</span>
                                </div>
                            </div>
                        </div>
                    </a>
                    <!-- END WIDGET THUMB -->
                </div>
                <div class="col-md-3">
                    <!-- BEGIN WIDGET THUMB -->

                    <a href="{{route('dashboard.jobs.index')}}" class="no-print">
                        <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 bordered">
                            <h4 class="widget-thumb-heading">{{ __('apps::dashboard._layout.aside.jobs') }}</h4>
                            <div class="widget-thumb-wrap">
                                <i class="widget-thumb-icon bg-purple icon-bag"></i>
                                <div class="widget-thumb-body">
                                <span class="widget-thumb-body-stat" data-counter="counterup"
                                      data-value="{{$jobs}}">0</span>
                                </div>
                            </div>
                        </div>
                    </a>

                    <a  class="show-print">
                        <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 bordered">
                            <h4 class="widget-thumb-heading">{{ __('apps::dashboard._layout.aside.jobs') }}</h4>
                            <div class="widget-thumb-wrap">
                                <i class="widget-thumb-icon bg-purple icon-bag"></i>
                                <div class="widget-thumb-body">
                                <span class="widget-thumb-body-stat" data-counter="counterup"
                                      data-value="{{$jobs}}">0</span>
                                </div>
                            </div>
                        </div>
                    </a>
                    <!-- END WIDGET THUMB -->
                </div>
                <div class="col-md-3">
                    <!-- BEGIN WIDGET THUMB -->
                    <a href="{{route('dashboard.jobs.index')}}" class="no-print">
                        <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 bordered">
                            <h4 class="widget-thumb-heading">{{ __('apps::dashboard._layout.aside.cvs') }}</h4>
                            <div class="widget-thumb-wrap">
                                <i class="widget-thumb-icon bg-blue icon-doc"></i>
                                <div class="widget-thumb-body">
                                <span class="widget-thumb-body-stat" data-counter="counterup"
                                      data-value="{{$cvs}}">0</span>
                                </div>
                            </div>
                        </div>
                    </a>
                    <a  class="show-print">
                        <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 bordered">
                            <h4 class="widget-thumb-heading">{{ __('apps::dashboard._layout.aside.cvs') }}</h4>
                            <div class="widget-thumb-wrap">
                                <i class="widget-thumb-icon bg-blue icon-doc"></i>
                                <div class="widget-thumb-body">
                                <span class="widget-thumb-body-stat" data-counter="counterup"
                                      data-value="{{$cvs}}">0</span>
                                </div>
                            </div>
                        </div>
                    </a>
                    <!-- END WIDGET THUMB -->
                </div>
            </div>
            @endpermission
            @endpermission
        </div>
    </div>

@stop

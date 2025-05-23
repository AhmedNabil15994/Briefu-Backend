@extends('apps::dashboard.layouts.app')
@section('title', __('company::dashboard.subscriptions.routes.index'))
@section('content')
<div class="page-content-wrapper">
    <div class="page-content">

        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <a href="{{ url(route('dashboard.home')) }}">{{ __('apps::dashboard.index.title') }}</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <a href="#">{{__('company::dashboard.subscriptions.routes.index')}}</a>
                </li>
            </ul>
        </div>

        @include('apps::dashboard.layouts._msg')

        <div class="row">
            <div class="col-md-12">
                @foreach ($packages as $key => $package)
                    <div class="col-md-3 ">
                        <!-- BEGIN Portlet PORTLET-->
                        <div class="portlet box {{ !empty($data['activeSubscription']) ? ($data['activeSubscription']->package_id == $package['id']) ? 'green' : 'red' : 'red' }}">

                            <div class="portlet-title">
                                <div class="caption">
                                    <center>{{ $package->translate(locale())->title }}</center>
                                 </div>
                                <div class="tools">
                                    @if (
                                            !empty($data['activeSubscription']) &&
                                            ($data['activeSubscription']->package_id == $package['id'])
                                        )
                                        <a href="javascript:;" class="collapse"></a>
                                    @else
                                        <a href="javascript:;" class="expand"></a>
                                    @endif
                                </div>
                            </div>

                            @if (
                                    !empty($data['activeSubscription']) &&
                                    ($data['activeSubscription']->package_id == $package['id'])
                                )
                                <div class="portlet-body">
                            @else
                                <div class="portlet-body portlet-collapsed">
                            @endif
                                <p>{!! $package->translate(locale())->description !!}</p>

                                <div class="pricing-content-1">
                                    <div class="price-column-container border-active">
                                        @foreach ($package->levels as $level)
                                            <div class="price-table-content">
                                                <div class="row mobile-padding">
                                                    <div class="col-xs-3 text-right mobile-padding">
                                                        <i class="fa fa-check"></i>
                                                    </div>
                                                    <div class="col-xs-9 text-left mobile-padding">
                                                        {{ $level->months > 0 ? $level->months : '♾️' }}
                                                        {{__('company::dashboard.subscriptions.form.months')}}
                                                    </div>
                                                </div>
                                                <div class="row mobile-padding">
                                                    <div class="col-xs-3 text-right mobile-padding">
                                                        <i class="fa fa-check"></i>
                                                    </div>
                                                    <div class="col-xs-9 text-left mobile-padding">
                                                        {{ $level->price }} KWD
                                                        {{__('company::dashboard.subscriptions.form.price')}}
                                                    </div>
                                                </div>
                                                <div class="row mobile-padding">
                                                    <div class="col-xs-3 text-right mobile-padding">
                                                        <i class="fa fa-check"></i>
                                                    </div>
                                                    <div class="col-xs-9 text-left mobile-padding">
                                                        {{ $level->job_posts > 0 ? $level->job_posts : '♾️' }}
                                                        {{__('company::dashboard.subscriptions.form.job_posts')}}
                                                    </div>
                                                </div>
                                                <div class="row mobile-padding">
                                                    <div class="col-xs-3 text-right mobile-padding">
                                                        @if ($level->company_in_home == true)
                                                            <i class="fa fa-check"></i>
                                                        @else
                                                            <i class="fa fa-times"></i>
                                                        @endif
                                                    </div>
                                                    <div class="col-xs-9 text-left mobile-padding">
                                                        {{__('company::dashboard.subscriptions.form.company_in_home')}}
                                                    </div>
                                                </div>
                                                <div class="row mobile-padding">
                                                    <div class="col-xs-3 text-right mobile-padding">
                                                        @if ($level->video_cv == true)
                                                            <i class="fa fa-check"></i>
                                                        @else
                                                            <i class="fa fa-times"></i>
                                                        @endif
                                                    </div>
                                                    <div class="col-xs-9 text-left mobile-padding">
                                                        {{__('company::dashboard.subscriptions.form.video_cv')}}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="arrow-down arrow-grey"></div>
                                        @endforeach

                                        @if (
                                                !empty($data['activeSubscription']) &&
                                                ($data['activeSubscription']->package_id == $package['id'])
                                            )

                                            <div class="price-table-footer">
                                                <button type="button" class="btn blue sbold uppercase price-button" disabled>
                                                    {{__('company::dashboard.subscriptions.form.subscribe_button')}}
                                                </button>
                                            </div>
                                        @else
                                            <div class="price-table-footer">
                                                <form class="form-horizontal form-row-seperated" method="post" enctype="multipart/form-data" action="{{route('dashboard.subscriptions.store')}}">
                                                    @csrf
                                                    <input type="hidden" name="package" value="{{ $package['id'] }}">
                                                    <button type="submit" class="btn blue sbold uppercase price-button">
                                                        {{__('company::dashboard.subscriptions.form.subscribe_button')}}
                                                    </button>
                                                </form>
                                            </div>
                                        @endif

                                    </div>
                                </div>

                            </div>
                        </div>
                        <!-- END Portlet PORTLET-->
                    </div>
                @endforeach
            </div>
        </div>

    </div>
</div>

@stop

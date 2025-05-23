@extends('apps::dashboard.layouts.app')
@section('title', __('course::dashboard.course_orders.routes.show'))
@section('content')

    <style type="text/css" media="print">
        @page {
            size: auto;
            margin: 0;
        }

        @media print {
            a[href]:after {
                content: none !important;
            }

            .contentPrint {
                width: 100%;
            }

            .no-print, .no-print * {
                display: none !important;
            }
        }
    </style>

    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <a href="{{ url(route('dashboard.home')) }}">{{ __('apps::dashboard.index.title') }}</a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <a href="{{ url(route('dashboard.course_orders.index')) }}">{{__('course::dashboard.course_orders.routes.index')}}</a>
                        <i class="fa fa-circle"></i>
                    </li>

                    <li>
                        <a href="#">{{__('course::dashboard.course_orders.routes.show')}}</a>
                    </li>

                </ul>
            </div>

            <h1 class="page-title"></h1>

            <div class="row">
                <div class="col-md-12">
                    <div class="no-print">
                        <div class="col-md-3">
                            <ul class="ver-inline-menu tabbable margin-bottom-10">
                                <li class="active">
                                    <a data-toggle="tab" href="#course">
                                        <i class="fa fa-cog"></i> {{__('course::dashboard.course_orders.form.tabs.course')}}
                                    </a>
                                    <span class="after"></span>
                                </li>
                                <li class="">
                                    <a data-toggle="tab" href="#course_orders">
                                        <i class="fa fa-cog"></i> {{__('course::dashboard.course_orders.form.tabs.course_orders')}}
                                    </a>
                                    <span class="after"></span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-9 contentPrint">
                        <div class="tab-content">

                            <div class="tab-pane active" id="course">
                                <div class="invoice-content-2 bcourse_ordersed">

                                    <div class="row margin-bottom-40">
                                        <div class="col-lg-12">
                                            <div class="portlet light about-text">

                                                <h4 style="background-color: #2b3743;">
                                                    <center>
                                                        {{ optional($order->course->translate(locale()))->title }}
                                                    </center>
                                                </h4>

                                                <div class="row">
                                                    <center>
                                                        <img src="{{ url(optional(optional($order->course)->company)->image ?? (setting('logo') ? url(setting('logo')):'/')) }}" alt=""
                                                             width="15%">
                                                        <h4>{{ optional(optional($order->course->company)->translate(locale()))->title }}</h4>
                                                    </center>
                                                </div>

                                                <p class="margin-top-20"> {!! optional($order->course->translate(locale()))->description !!} </p>

                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="tab-pane" id="course_orders">
                                <div class="invoice-content-2 bcourse_ordersed">

                                    <div class="profile-sidebar">

                                        <div class="portlet light profile-sidebar-portlet ">

                                            <div class="profile-userpic">
                                                <img src="{{ url(optional($order->user)->image) }}" class="img-responsive" alt="">
                                            </div>

                                            <div class="profile-usertitle">
                                                <div class="profile-usertitle-name"> {{ optional($order->user)->name }} </div>
                                            </div>
                                        </div>
                                        <div class="portlet light ">

                                            <hr>
                                            <div>
                                                <label class="caption-subject font-blue-madison bold ">{{__('job::dashboard.cvs.form.mobile')}} :</label>
                                                <span class="profile-desc-title" style="font-size: 13px;">{{ (optional($order)->country_code ?? '965') .' '. optional($order)->mobile }}</span>
                                            </div>
                                            <div>
                                                <label class="caption-subject font-blue-madison bold ">{{__('job::dashboard.cvs.form.email')}} :</label>
                                                <span class="profile-desc-title" style="font-size: 13px;">{{ optional($order)->email }}</span>
                                            </div>

                                        @if(optional($order->user)->profileCv)
                                                <div class="row list-separated profile-stat">
                                                    <div class="col-md-4 col-sm-4 col-xs-6">
                                                        <div class="uppercase profile-stat-text">
                                                            {{ optional(optional(optional($order->user->profileCv)->qualification)->translate(locale()))->title }}
                                                            / {{ optional(optional($order->user)->profileCv)->graduate_year }} </div>
                                                    </div>
                                                    <div class="col-md-4 col-sm-4 col-xs-6">
                                                        <div class="uppercase profile-stat-text"> {{ optional($order->user->profileCv)->faculty }} </div>
                                                    </div>
                                                    <div class="col-md-4 col-sm-4 col-xs-6">
                                                        <div class="uppercase profile-stat-text"> {{ optional(optional($order->user)->profileCv)->major }} </div>
                                                    </div>
                                                </div>

                                                <div>
                                                    <h4 class="profile-desc-title">{{ optional(optional($order->user)->profileCv)->gender }}</h4>
                                                </div>

                                                <div>
                                                    <p class="profile-desc-title">
                                                        <a href="{{asset(optional(optional($order->user)->profileCv)->cv_pdf)}}" class="btn btn-success" target="_blank">
                                                            {{ __('course::dashboard.course_orders.form.cv_pdf') }}
                                                        </a>
                                                    </p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="profile-content">

                                        <div class="row">

                                            <div class="col-md-12">
                                                <!-- BEGIN PORTLET -->
                                                <div class="portlet light ">
                                                    <div class="portlet-title">
                                                        <div class="caption caption-md">
                                                            <i class="icon-bar-chart theme-font hide"></i>
                                                            <span class="caption-subject font-blue-madison bold uppercase">
								                            {{__('course::dashboard.course_orders.form.courses')}}
								                        </span>
                                                        </div>
                                                    </div>
                                                    <div class="portlet-body">
                                                        <div class="table-scrollable table-scrollable-borderless">
                                                            <table class="table table-hover table-light">
                                                                <thead>
                                                                <tr class="uppercase">
                                                                    <th colspan="2"> {{__('course::dashboard.course_orders.form.courses')}} </th>
                                                                    <th colspan="2"> {{__('course::dashboard.course_orders.form.address')}} </th>
                                                                    <th colspan="2"> {{__('course::dashboard.course_orders.form.hrs')}} </th>
                                                                    <th colspan="2"> {{__('course::dashboard.course_orders.form.from')}} </th>
                                                                </tr>
                                                                </thead>
                                                                @foreach (optional($order->user)->certifications as $key => $certificat)
                                                                    <tr>
                                                                        <td colspan="2"> {{ $certificat->certificat }} </td>
                                                                        <td colspan="2"> {{ $certificat->address }} </td>
                                                                        <td colspan="2"> {{ $certificat->hours }} </td>
                                                                        <td colspan="2"> {{ $certificat->from }} </td>
                                                                        <td colspan="2"> {{ $certificat->to }} </td>
                                                                    </tr>
                                                                @endforeach
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- END PORTLET -->
                                            </div>

                                            <div class="col-md-12">
                                                <!-- BEGIN PORTLET -->
                                                <div class="portlet light ">
                                                    <div class="portlet-title">
                                                        <div class="caption caption-md">
                                                            <i class="icon-bar-chart theme-font hide"></i>
                                                            <span class="caption-subject font-blue-madison bold uppercase">
								                            {{__('course::dashboard.course_orders.form.experiences')}}
								                        </span>
                                                        </div>
                                                    </div>
                                                    <div class="portlet-body">
                                                        <div class="table-scrollable table-scrollable-borderless">
                                                            <table class="table table-hover table-light">
                                                                <thead>
                                                                <tr class="uppercase">
                                                                    <th colspan="2"> {{__('course::dashboard.course_orders.form.company')}} </th>
                                                                    <th colspan="2"> {{__('course::dashboard.course_orders.form.company_address')}}</th>
                                                                    <th colspan="2"> {{__('course::dashboard.course_orders.form.position')}} </th>
                                                                    <th colspan="2"> {{__('course::dashboard.course_orders.form.from')}} </th>
                                                                    <th colspan="2"> {{__('course::dashboard.course_orders.form.to')}} </th>
                                                                </tr>
                                                                </thead>
                                                                @foreach (optional($order->user)->experiences as $key => $experience)
                                                                    <tr>
                                                                        <td colspan="2"> {{ $experience->company }} </td>
                                                                        <td colspan="2"> {{ $experience->company_address }} </td>
                                                                        <td colspan="2"> {{ $experience->position }} </td>
                                                                        <td colspan="2"> {{ $experience->from }} </td>
                                                                        <td colspan="2"> {{ is_null($experience->to) ? ' ---' : $experience->to }} </td>
                                                                    </tr>
                                                                @endforeach
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- END PORTLET -->
                                            </div>

                                            <div class="col-md-12">
                                                <!-- BEGIN PORTLET -->
                                                <div class="portlet light ">
                                                    <div class="portlet-title">
                                                        <div class="caption caption-md">
                                                            <i class="icon-bar-chart theme-font hide"></i>
                                                            <span class="caption-subject font-blue-madison bold uppercase">
								                            {{__('course::dashboard.course_orders.form.target')}}
								                        </span>
                                                        </div>
                                                    </div>
                                                    <div class="portlet-body">
                                                        <div class="table-scrollable table-scrollable-borderless">
                                                            <table class="table table-hover table-light">
                                                                @foreach (optional($order->user)->target as $key => $target)
                                                                    <tr>
                                                                        <td> {{ optional($target->attribute->translate(locale()))->title }}
                                                                            :
                                                                        </td>
                                                                        <td> {{ $target->translate(locale())->title }} </td>
                                                                    </tr>
                                                                @endforeach
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- END PORTLET -->
                                            </div>

                                            <div class="col-md-12">
                                                <!-- BEGIN PORTLET -->
                                                <div class="portlet light ">
                                                    <div class="portlet-title">
                                                        <div class="caption caption-md">
                                                            <i class="icon-bar-chart theme-font hide"></i>
                                                            <span class="caption-subject font-blue-madison bold uppercase">
								                            {{__('course::dashboard.course_orders.form.video_cv')}}
								                        </span>
                                                        </div>
                                                    </div>
                                                    <div class="portlet-body">
                                                        @if(optional($order->user)->videoCv)
                                                            @if(optional($order->user)->videoCv->video_status == 'loaded')
                                                                {!! \Modules\User\Repositories\Api\VideoIntegrationRepository::buildVideo(optional(optional($order->user)->videoCv)->video) !!}
                                                            @else
                                                                <div class="text-center" style="background-color: #ffc96559;
    padding: 14px;
    border: 1px solid orange;">{{__('course::dashboard.course_orders.form.loading')}}</div>
                                                            @endif
                                                        @else
                                                            <div class="text-center" style="background-color: #ffc96559;
    padding: 14px;
    border: 1px solid red;">{{__('course::dashboard.course_orders.form.not_have_video_cv')}}</div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

@stop

@section('scripts')

    <script>
        $('.24_format').timepicker({
            showMeridian: true,
            format: 'hh:mm',
        });

        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
            startDate: '0d'
        });
    </script>

@stop

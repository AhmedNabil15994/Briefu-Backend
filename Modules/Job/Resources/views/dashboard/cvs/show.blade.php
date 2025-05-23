@extends('apps::dashboard.layouts.app')
@section('title', __('job::dashboard.cvs.routes.show'))
@section('css')
    <style>
        .portlet.light {
            padding: 12px 20px 15px;
            background-color: #f5f9ff;
            border-radius: 6px;
        }
        .table-scrollable>.table {
            width: 100%!important;
            margin: 0!important;
            background-color: transparent;
        }
        .portlet {
            box-shadow: none;
        }
        .profile-sidebar-portlet {
            padding: 30px 0 30px 0!important;
        }
    </style>
@endsection
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
                        <a href="{{ url(route('dashboard.jobs.show',$jobId)) }}">{{__('job::dashboard.cvs.routes.index')}}</a>
                        <i class="fa fa-circle"></i>
                    </li>

                    <li>
                        <a href="#">{{__('job::dashboard.cvs.routes.show')}}</a>
                    </li>

                </ul>
            </div>

            <h1 class="page-title"></h1>

            <div class="row">
                <div class="col-md-12">
                    <div class="no-print">
                        <div class="col-md-3">
                            <ul class="ver-inline-menu tabbable margin-bottom-10">
                                {{-- <li class="active">
                                    <a data-toggle="tab" href="#job">
                                        <i class="fa fa-cog"></i> {{__('job::dashboard.cvs.form.tabs.job')}}
                                    </a>
                                    <span class="after"></span>
                                </li> --}}
                                <li class="active">
                                    <a data-toggle="tab" href="#cvs">
                                        <i class="fa fa-cog"></i> {{__('job::dashboard.cvs.form.tabs.cvs')}}
                                    </a>
                                    <span class="after"></span>
                                </li>
                                {{--							<li class="">--}}
                                {{--                                <a data-toggle="tab" href="#video">--}}
                                {{--                                    <i class="fa fa-cog"></i> UPDATE VIDEO CV--}}
                                {{--                                </a>--}}
                                {{--                                <span class="after"></span>--}}
                                {{--                            </li>--}}
                                <li class="">
                                    <a data-toggle="tab" href="#update_request">
                                        <i class="fa fa-cog"></i>
                                        {{__('job::dashboard.cvs.form.tabs.update_request')}}
                                    </a>
                                    <span class="after"></span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-9 contentPrint">

                        <div class="tab-content">


                            @include('job::dashboard.cvs.components.cv-data' , ['user' => $cv->user])

                            <div class="tab-pane" id="update_request">
                                <div class="invoice-content-2">
                                    <form id="updateForm" page="form" class="form-horizontal form-row-seperated"
                                          method="post" enctype="multipart/form-data"
                                          action="{{route('dashboard.cvs.update',$cv->id)}}">
                                        @csrf
                                        @method('PUT')
                                        {!! field()->select('status' , __('job::dashboard.cvs.form.cv_status'),
                                        Modules\Job\Entities\JobUser::getOptionsForSelect(),$cv->status) !!}
                                        <div class="col-md-12">
                                            <div class="form-actions">
                                                @include('apps::dashboard.layouts._ajax-msg')
                                                <div class="form-group">
                                                    <button type="submit" id="submit" class="btn btn-lg green">
                                                        {{__('apps::dashboard.buttons.edit')}}
                                                    </button>
                                                    <a href="{{url(route('dashboard.jobs.index')) }}"
                                                       class="btn btn-lg red">
                                                        {{__('apps::dashboard.buttons.back')}}
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
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

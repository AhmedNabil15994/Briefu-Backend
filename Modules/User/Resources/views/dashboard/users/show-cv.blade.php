@extends('apps::dashboard.layouts.app')
@section('title', __('user::dashboard.users.index.title'))

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
                        <a href="#">{{__('user::dashboard.users.index.title')}}</a>
                    </li>
                    <li>
                        <a href="#">{{__('job::dashboard.cvs.routes.show')}}</a>
                    </li>

                </ul>
            </div>

            <h1 class="page-title"></h1>

            <div class="row">
                <div class="col-md-12">
                    <div class="tab-content">
                        @include('job::dashboard.cvs.components.cv-data' , ['user' => $user])
                    </div>
                </div>

            </div>
        </div>
    </div>
@stop


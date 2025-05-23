@extends('apps::dashboard.layouts.app')
@section('title', __('report::dashboard.reports.routes.index'))
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
                        <a href="#">{{__('report::dashboard.reports.routes.index')}}</a>
                    </li>
                </ul>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="portlet light bordered">

                        {{-- DATATABLE FILTER --}}
                        <div class="row">
                            <div class="portlet box grey-cascade">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="fa fa-gift"></i>
                                        {{__('apps::dashboard.datatable.search')}}
                                    </div>
                                    <div class="tools">
                                        <a href="javascript:;" class="collapse" data-original-title="" title=""> </a>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <div id="filter_data_table">
                                        <div class="panel-body">
                                            <form id="formFilter" class="horizontal-form">
                                                <div class="form-body">
                                                    <div class="row">

                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label class="control-label">
                                                                    {{__('apps::dashboard.datatable.form.date_range')}}
                                                                </label>
                                                                <div id="reportrange" class="btn default form-control">
                                                                    <i class="fa fa-calendar"></i> &nbsp;
                                                                    <span> </span>
                                                                    <b class="fa fa-angle-down"></b>
                                                                    <input type="hidden" name="from">
                                                                    <input type="hidden" name="to">
                                                                </div>
                                                            </div>
                                                        </div>


                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label class="control-label">
                                                                    {{__('report::dashboard.reports.datatable.company')}}
                                                                </label>
                                                                <select name="company_id" id="single"
                                                                        class="form-control">
                                                                    <option value="">
                                                                        {{__('apps::dashboard.datatable.form.select')}}
                                                                    </option>
                                                                    @foreach ($companies as $company)
                                                                        <option value="{{ $company['id'] }}">
                                                                            {{ $company->translate(locale())->title }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>


                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label class="control-label">
                                                                    {{__('report::dashboard.reports.datatable.package')}}
                                                                </label>
                                                                <select name="package_id" id="single"
                                                                        class="form-control">
                                                                    <option value="">
                                                                        {{__('apps::dashboard.datatable.form.select')}}
                                                                    </option>
                                                                    @foreach ($packages as $package)
                                                                        <option value="{{ $package['id'] }}">
                                                                            {{ $package->translate(locale())->title }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                            <div class="form-actions">
                                                <button class="btn btn-sm green btn-outline filter-submit margin-bottom"
                                                        id="search">
                                                    <i class="fa fa-search"></i>
                                                    {{__('apps::dashboard.datatable.search')}}
                                                </button>
                                                <button class="btn btn-sm red btn-outline filter-cancel">
                                                    <i class="fa fa-times"></i>
                                                    {{__('apps::dashboard.datatable.reset')}}
                                                </button>
                                            </div>
                                            @include('apps::dashboard.components.datatable.show-deleted-btn')
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- END DATATABLE FILTER --}}


                        <div class="portlet-title">
                            <div class="caption font-dark">
                                <i class="icon-settings font-dark"></i>
                                <span class="caption-subject bold uppercase">
                                {{__('report::dashboard.reports.routes.index')}}
                            </span>
                            </div>
                        </div>

                        {{-- DATATABLE CONTENT --}}
                        <div class="portlet-body">
                            <table class="table table-striped table-bordered table-hover" id="dataTable">
                                <thead>
                                <tr>
                                    <th colspan="6"></th>
                                    <th colspan="6"></th>
                                </tr>
                                <tr>
                                    <th class="hideInPrint">
                                        <a href="javascript:;" onclick="CheckAll()">
                                            {{__('apps::dashboard.buttons.select_all')}}
                                        </a>
                                    </th>
                                    <th>#</th>
                                    <th>{{__('report::dashboard.reports.datatable.start_date')}}</th>
                                    <th>{{__('report::dashboard.reports.datatable.end_date')}}</th>
                                    <th>{{__('report::dashboard.reports.datatable.company')}}</th>
                                    <th>{{__('report::dashboard.reports.datatable.package')}}</th>
                                    <th>{{__('report::dashboard.reports.datatable.price')}}</th>
                                    <th>{{__('report::dashboard.reports.datatable.created_at')}}</th>
                                    <th class="hideInPrint">{{__('report::dashboard.reports.datatable.options')}}</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                        <div class="row">
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('scripts')

<script src="/admin/js/datatables/buttons.server-side.js" type="text/javascript"></script>
    <script>
        function tableGenerate(data = '') {

            var dataTable =
                $('#dataTable').DataTable({
                    "createdRow": function (row, data, dataIndex) {
                        if (data["deleted_at"] != null) {
                            $(row).addClass('danger');
                        }
                    },
                    ajax: {
                        url: "{{ url(route('dashboard.reports.subscriptions.datatable')) }}",
                        type: "GET",
                        data: {
                            req: data,
                        },
                    },
                    language: {
                        url: "//cdn.datatables.net/plug-ins/1.10.16/i18n/{{ucfirst(LaravelLocalization::getCurrentLocaleName())}}.json"
                    },
                    stateSave: true,
                    processing: true,
                    serverSide: true,
                    responsive: !0,
                    order: [[1, "desc"]],
                    "headerCallback": function (thead, data, start, end, display) {
                        $(thead).addClass('success');

                        var api = this.api(), data;

                        var intVal = function (i) {
                            return typeof i === 'string' ?
                                i.replace(/[\$,]/g, '') * 1 :
                                typeof i === 'number' ?
                                    i : 0;
                        };

                        var total = api
                            .column(6)
                            .data()
                            .reduce(function (a, b) {
                                return intVal(a) + intVal(b);
                            }, 0);

                        $(thead).find('th').eq(0).html("Total");
                        $(thead).find('th').eq(1).html(total + " KWD");

                    },
                    columns: [
                        {data: 'id', className: 'dt-center'},
                        {data: 'id', className: 'dt-center'},
                        {data: 'date_from', className: 'dt-center'},
                        {data: 'date_to', className: 'dt-center'},
                        {data: 'company', className: 'dt-center'},
                        {data: 'package', className: 'dt-center'},
                        {data: 'price', className: 'dt-center'},
                        {data: 'created_at', className: 'dt-center'},
                        {data: 'id', responsivePriority: 1},
                    ],
                    columnDefs: [
                        {
                            targets: 0,
                            width: '30px',
                            className: 'dt-center',
                            orderable: false,
                            render: function (data, type, full, meta) {
                                return `<label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                          <input type="checkbox" value="` + data + ` class="group-checkable" name="ids">
                                          <span></span>
                                        </label>
                                      `;
                            },
                        },
                        {
                            targets: -1,responsivePriority: 1 ,
                            width: '13%',
                            title: '{{__('report::dashboard.reports.datatable.options')}}',
                            className: 'dt-center',
                            orderable: false,
                            render: function (data, type, full, meta) {
                                return ``;
                            },
                        },
                    ],
                    dom: 'Bfrtip',
                    lengthMenu: [
                        [10, 25, 50, 100, 500],
                        ['10', '25', '50', '100', '500']
                    ],
                    buttons: [
                        {
                            extend: "pageLength",
                            className: "btn blue btn-outline",
                            text: "{{__('apps::dashboard.datatable.pageLength')}}",
                            exportOptions: {
                                stripHtml: true,
                                columns: ':visible'
                            }
                        },
                       {
                            extend: "print",
                            className: "btn blue btn-outline",
                            text: "{{__('apps::dashboard.datatable.print')}}",
                            url: "{{route('dashboard.reports.subscriptions.export' , 'print')}}",
                            data: {
                                req: data,
                            },
                            exportOptions: {
                                stripHtml: false,
                                columns: ':visible',
                                columns: [1, 2, 3, 4, 5]
                            }
                        },
                        {
                            extend: "pdf",
                            className: "btn blue btn-outline",
                            text: "{{__('apps::dashboard.datatable.pdf')}}",
                            url: "{{route('dashboard.reports.subscriptions.export' , 'pdf')}}",
                            data: {
                                req: data,
                            },
                            exportOptions: {
                                stripHtml: false,
                                columns: ':visible',
                                columns: [1, 2, 3, 4, 5]
                            }
                        },
                        {
                            extend: "excel",
                            className: "btn blue btn-outline ",
                            text: "{{__('apps::dashboard.datatable.excel')}}",
                            url: "{{route('dashboard.reports.subscriptions.export' , 'excel')}}",
                            data: {
                                req: data,
                            },
                            exportOptions: {
                                stripHtml: false,
                                columns: ':visible',
                                columns: [1, 2, 3, 4, 5]
                            }
                        }
                    ]
                });
        }

        jQuery(document).ready(function () {
            tableGenerate();
        });
    </script>

@stop

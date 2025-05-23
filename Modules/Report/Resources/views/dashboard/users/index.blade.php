@extends('apps::dashboard.layouts.app')
@section('title', __('report::dashboard.reports.users.routes.index'))
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
                        <a href="#">{{__('report::dashboard.reports.users.routes.index')}}</a>
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
                                                            @include('user::dashboard.users.components.select-search.index')
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label class="control-label">
                                                                    {{__('report::dashboard.reports.users.datatable.gender')}}
                                                                </label>
                                                                @php 
                                                                    $genders = [
                                                                        "male",
                                                                        "female",
                                                                    ];
                                                                @endphp
                                                                <select name="gender" id="single"
                                                                        class="form-control select2">
                                                                    <option value="">
                                                                        {{__('apps::dashboard.datatable.form.select')}}
                                                                    </option>
                                                                    @foreach ($genders as $gender)
                                                                        <option value="{{ $gender }}">
                                                                            {{ __("report::dashboard.reports.users.datatable.{$gender}") }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label class="control-label">
                                                                    {{__('report::dashboard.reports.users.datatable.country')}}
                                                                </label>
                                                                <select name="country_id" id="single"
                                                                        class="form-control select2">
                                                                    <option value="">
                                                                        {{__('apps::dashboard.datatable.form.select')}}
                                                                    </option>
                                                                    @foreach ($countries as $country)
                                                                        <option value="{{ $country->id }}">
                                                                            {{ optional($country->translate(locale()))->title }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label class="control-label">
                                                                    {{__('report::dashboard.reports.users.datatable.attributes')}}
                                                                </label>
                                                                <select name="attribute_id" id="single"
                                                                        class="form-control select2">
                                                                    <option value="">
                                                                        {{__('apps::dashboard.datatable.form.select')}}
                                                                    </option>
                                                                    @foreach ($attributes as $attribute)
                                                                        <option value="{{ $attribute->id }}">
                                                                            {{ optional($attribute->translate(locale()))->title }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label class="control-label">
                                                                    {{__('user::dashboard.users.datatable.user_type')}}
                                                                </label>
                                                                <select name="user_type" id="single"
                                                                        class="form-control select2">
                                                                    <option value="">
                                                                        {{__('user::dashboard.users.datatable.select_user_type')}}
                                                                    </option>
                                                                    
                                                                    <option value="special">
                                                                        {{__('user::dashboard.users.datatable.special')}}
                                                                    </option>
                                                                    
                                                                    <option value="not_special">
                                                                        {{__('user::dashboard.users.datatable.not_special')}}
                                                                    </option>
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
                                {{__('report::dashboard.reports.users.routes.index')}}
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
                                    <th>{{__('report::dashboard.reports.datatable.client')}}</th>
                                    <th>{{__('report::dashboard.reports.users.datatable.country')}}</th>
                                    <th>{{__('report::dashboard.reports.users.datatable.nationality_id')}}</th>
                                    <th>{{__('report::dashboard.reports.users.datatable.gender')}}</th>
                                    <th>{{__('report::dashboard.reports.users.datatable.attributes')}}</th>
                                    <th>{{__('report::dashboard.reports.users.datatable.subscription')}}</th>
                                    <th>{{__('report::dashboard.reports.users.datatable.created_at')}}</th>
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
@include('user::dashboard.users.components.select-search.script')
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
                        url: "{{ route('dashboard.reports.users.datatable') }}",
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
                    columns: [
                        {data: 'id', className: 'dt-center'},
                        {data: 'id', className: 'dt-center'},
                        {
                            data: 'name', 
                            className: 'dt-center',
                            width: '30px',
                            render: function (data, type, full, meta) {

                                // Edit
                                var url = '{{ route("dashboard.users.edit", ":id") }}';
                                url = url.replace(':id', full.id);

                                return `<a href="${url}"> ${data}</br><span style="text-align:left">${full.mobile}</span></br>${full.email} </a>`
                                
                            },
                        },
                        {data: 'country', className: 'dt-center'},
                        {data: 'nationality_id', className: 'dt-center'},
                        {data: 'gender', className: 'dt-center'},
                        {data: 'attributes', className: 'dt-center'},
                        {data: 'subscription', className: 'dt-center'},
                        {data: 'created_at', className: 'dt-center'},
                    ],
                    "fnDrawCallback": function() {
                        //Initialize checkbos for enable/disable user
                        $("[name='switch']").bootstrapSwitch({size: "small", onColor:"success", offColor:"danger"});
                    },
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
                            url: "{{route('dashboard.reports.users.export' , 'print')}}",
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
                            url: "{{route('dashboard.reports.users.export' , 'pdf')}}",
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
                            url: "{{route('dashboard.reports.users.export' , 'excel')}}",
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
                            extend: "colvis",
                            className: "btn blue btn-outline",
                            text: "{{__('apps::dashboard.datatable.colvis')}}",
                            exportOptions: {
                                stripHtml: true,
                                columns: ':visible'
                            }
                        }
                    ]
                });
        }

        jQuery(document).ready(function () {
            tableGenerate();
        });


    $(document).ready(function () {

        var start = moment().subtract(29, 'days');
        var end = moment();

        function cb(start, end) {
            if (start.isValid() && end.isValid()) {
                $('#reportrange2 span').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
                $('input[name="expired_date_from"]').val(start.format('YYYY-MM-DD'));
                $('input[name="expired_date_to"]').val(end.format('YYYY-MM-DD'));
            } else {
                $('#reportrange2 .form-control').val('Without Dates');
                $('input[name="expired_date_from"]').val('');
                $('input[name="expired_date_to"]').val('');
            }
        }

        $('#reportrange2').daterangepicker({
            startDate: start,
            endDate: end,
            ranges: {
                '{{__('apps::dashboard.buttons.datapicker.today')}}': [moment(), moment()],
                '{{__('apps::dashboard.buttons.datapicker.yesterday')}}': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                '{{__('apps::dashboard.buttons.datapicker.7days')}}': [moment().subtract(6, 'days'), moment()],
                '{{__('apps::dashboard.buttons.datapicker.30days')}}': [moment().subtract(29, 'days'), moment()],
                '{{__('apps::dashboard.buttons.datapicker.month')}}': [moment().startOf('month'), moment().endOf('month')],
                '{{__('apps::dashboard.buttons.datapicker.last_month')}}': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
            },
            @if (is_rtl() == 'rtl')
            opens: 'left',
            @endif
            buttonClasses: ['btn'],
            applyClass: 'btn-primary',
            cancelClass: 'btn-danger',
            format: 'YYYY-MM-DD',
            separator: 'to',
            locale: {
                applyLabel: '{{__('apps::dashboard.buttons.save')}}',
                cancelLabel: '{{__('apps::dashboard.buttons.cancel')}}',
                fromLabel: '{{__('apps::dashboard.buttons.from')}}',
                toLabel: '{{__('apps::dashboard.buttons.to')}}',
                customRangeLabel: '{{__('apps::dashboard.buttons.custom')}}',
                firstDay: 1
            }
        }, cb);

        cb(start, end);

    });
    </script>

@stop

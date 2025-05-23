@extends('apps::dashboard.layouts.app')
@section('title', __('company::dashboard.companies.routes.update'))
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
                        <a href="{{ url(route('dashboard.companies.index')) }}">
                            {{__('company::dashboard.companies.routes.index')}}
                        </a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <a href="#">{{__('company::dashboard.companies.routes.update')}}</a>
                    </li>
                </ul>
            </div>

            <h1 class="page-title"></h1>

            <div class="row">
                <div class="col-md-12">

                    <div class="col-md-3">
                        <div class="panel-group accordion scrollable" id="accordion2">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title"><a class="accordion-toggle"></a></h4>
                                </div>
                                <div id="collapse_2_1" class="panel-collapse in">
                                    <div class="panel-body">
                                        <ul class="nav nav-pills nav-stacked">

                                            <li class="active">
                                                <a href="#global_setting" data-toggle="tab">
                                                    {{ __('company::dashboard.companies.form.tabs.general') }}
                                                </a>
                                            </li>

                                            <li class="">
                                                <a href="#subscriptions" data-toggle="tab">
                                                    {{ __('company::dashboard.companies.form.tabs.subscriptions') }}
                                                </a>
                                            </li>

                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-9">
                        <div class="tab-content">

                            <div class="tab-pane active fade in" id="global_setting">

                                <form id="updateForm" page="form" class="form-horizontal form-row-seperated" method="post" enctype="multipart/form-data" action="{{route('dashboard.companies.update',$company->id)}}">
                                    @csrf
                                    @method('PUT')
                                    <h3 class="page-title">{{__('company::dashboard.companies.form.tabs.general')}}</h3>
                                    <div class="col-md-10">

                                        <div class="tabbable">
                                            <ul class="nav nav-tabs bg-slate nav-tabs-component">
                                                @foreach (config('laravellocalization.supportedLocales') as $code => $lang)
                                                    <li class=" {{ ($code == locale()) ? 'active' : '' }}">
                                                        <a href="#colored-rounded-tab-general-{{$code}}" data-toggle="tab" aria-expanded="false"> {{ $lang['native'] }}
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>

                                        <div class="tab-content">
                                            @foreach (config('laravellocalization.supportedLocales') as $code => $lang)
                                                <div class="tab-pane fade in {{ ($code == locale()) ? 'active' : '' }}" id="colored-rounded-tab-general-{{$code}}">

                                                    <div class="form-group">
                                                        <label class="col-md-2">
                                                            {{__('company::dashboard.companies.form.title')}} - {{ $code }}
                                                        </label>
                                                        <div class="col-md-9">
                                                            <input type="text" name="title[{{$code}}]" class="form-control" data-name="title.{{$code}}" value="{{ $company->translate($code)->title }}" {{ (is_rtl($code) == 'rtl') ? 'dir=rtl' : '' }}>
                                                            <div class="help-block"></div>
                                                        </div>
                                                    </div>

                                                </div>
                                            @endforeach
                                        </div>

                                        {!! field()->multiSelect('users' , __('company::dashboard.companies.form.users') , $users->pluck('name','id')->toArray()??[] , $company->users->pluck('id')->toArray()??[]) !!}

                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{__('company::dashboard.companies.form.state')}}
                                            </label>
                                            <div class="col-md-9">
                                                <select name="state_id" id="single" class="form-control select2-allow-clear">
                                                    <option value=""></option>
                                                    @foreach ($cities as $city)
                                                        <optgroup label="{{ $city->translate(locale())->title }}">
                                                            @foreach ($city->states as $state)
                                                                <option value="{{ $state['id'] }}" {{ $company->state_id == $state['id'] ? 'selected' : '' }}>
                                                                    {{ $state->translate(locale())->title }}
                                                                </option>
                                                            @endforeach
                                                        </optgroup>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        @php $subscriptionNow = $company->subscriptions->where('is_active_now',true)->first();@endphp

                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{__('company::dashboard.companies.form.package')}}
                                            </label>
                                            <div class="col-md-9">
                                                <select name="package" class="form-control select2 package_" data-name="package">
                                                    <option value=""></option>
                                                    @foreach ($packages as $package)
                                                        <option value="{{$package['id']}}" {{ $subscriptionNow ? $subscriptionNow->package_id == $package['id'] ? 'selected' : ''  : ''}}>
                                                            {{ $package['id'] }} - {{ $package->translate(locale())->title }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <div class="help-block"></div>
                                            </div>
                                        </div>


                                        <div class="form-group row" style="display: none" id="loader">

                                            <label class="col-md-2">
                                            </label>
                                            <div class="col-md-9">
                                                <strong style="color: #26c281;">@lang("Loading")...</strong>
                                            </div>
                                        </div>
                                        <div id="prices">
                                            @if($subscriptionNow)
                                                    <?php $prices_ids = [];?>
                                                @if($subscriptionNow->package)
                                                    @if($subscriptionNow->package->levels)
                                                            <?php $prices_ids = $subscriptionNow->package->levels->pluck('price','id')->toArray()??[];?>
                                                    @endif
                                                @endif

                                                @include('company::dashboard.subscriptions.components.package-levels-selector',
                                                ['prices' => $prices_ids,'selected_price_id' => $subscriptionNow->level_id]
                                                )
                                            @endif
                                        </div>

                                        <input type="hidden" name="old_package" value="{{ $company->activeSubscription() ? $company->activeSubscription()->package_id : '' }}">

                                        {!! field()->file('image',__('company::dashboard.companies.form.image'),$company->image ? url($company->image) : null) !!}

                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{__('company::dashboard.companies.form.status')}}
                                            </label>
                                            <div class="col-md-9">
                                                <input type="checkbox" class="make-switch" id="test" data-size="small" name="status" {{($company->status == 1) ? ' checked="" ' : ''}}>
                                                <div class="help-block"></div>
                                            </div>
                                        </div>

                                        @if ($company->trashed())
                                            <div class="form-group">
                                                <label class="col-md-2">
                                                    {{__('company::dashboard.companies.form.restore')}}
                                                </label>
                                                <div class="col-md-9">
                                                    <input type="checkbox" class="make-switch" id="test" data-size="small" name="restore">
                                                    <div class="help-block"></div>
                                                </div>
                                            </div>
                                        @endif

                                    </div>
                                    {{-- PAGE ACTION --}}
                                    <div class="col-md-12">
                                        <div class="form-actions">
                                            @include('apps::dashboard.layouts._ajax-msg')
                                            <div class="form-group">
                                                <button type="submit" id="submit" class="btn btn-lg green">
                                                    {{__('apps::dashboard.buttons.edit')}}
                                                </button>
                                                <a href="{{url(route('dashboard.companies.index')) }}" class="btn btn-lg red">
                                                    {{__('apps::dashboard.buttons.back')}}
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="tab-pane fade in" id="subscriptions">
                                <form id="update_subscription" page="form" class="form-horizontal form-row-seperated" method="post" enctype="multipart/form-data" action="{{route('dashboard.companies.update.subscription',$company->id)}}">
                                    @csrf
                                    @method('PUT')
                                    <h3 class="page-title">{{__('company::dashboard.companies.form.tabs.subscriptions')}}</h3>
                                    <div class="col-md-10" id="subscription_form">
                                        <input type="hidden" name="package" value="{{ $subscriptionNow ? $subscriptionNow->package_id  : ''}}">
                                        @foreach ($company->subscriptions->where('is_active_now',true) as $key => $subcription)

                                            <div class="form-group row">
                                                <label class="col-md-2">
                                                    {{__('company::dashboard.companies.form.date_from')}}
                                                </label>
                                                <div class="col-md-4">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control datepicker" name="date_from[{{$subcription['id']}}]" data-name="date_from" autocomplete="false" value="{{ $subcription->date_from }}">
                                                        <span class="input-group-btn">
                                                            <button class="btn default" type="button">
                                                                <i class="fa fa-calendar"></i>
                                                            </button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-md-2">
                                                    {{__('company::dashboard.companies.form.date_to')}}
                                                </label>
                                                <div class="col-md-4">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control datepicker" name="date_to[{{$subcription['id']}}]" data-name="date_to" autocomplete="false" value="{{ $subcription->date_to }}">
                                                        <span class="input-group-btn">
                                                            <button class="btn default" type="button">
                                                                <i class="fa fa-calendar"></i>
                                                            </button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- <div class="form-group">
                                                <label class="col-md-2">
                                                    {{__('package::dashboard.packages.form.sort')}}
                                                </label>
                                                <div class="col-md-9">
                                                    <input type="text" name="sort[{{$subcription['id']}}]" class="form-control" data-name="sort" value="{{ $subcription->sort }}">
                                                    <div class="help-block"></div>
                                                </div>
                                            </div> --}}

                                            <div class="form-group row">
                                                <label class="col-md-2">
                                                    {{__('package::dashboard.packages.form.price')}}
                                                </label>
                                                <div class="col-md-9">
                                                    <input type="text" name="price[{{$subcription['id']}}]" class="form-control" data-name="price" value="{{ $subcription->price }}">
                                                    <div class="help-block"></div>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-md-2">
                                                    {{__('package::dashboard.packages.form.job_posts')}}
                                                </label>
                                                <div class="col-md-9">
                                                    <input type="text" name="job_posts[{{$subcription['id']}}]" class="form-control" data-name="job_posts" value="{{ $subcription->job_posts }}">
                                                    <div class="help-block"></div>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-md-2">
                                                    {{__('package::dashboard.packages.form.months')}}
                                                </label>
                                                <div class="col-md-9">
                                                    <input type="text" name="months[{{$subcription['id']}}]" class="form-control" data-name="months" value="{{ $subcription->months }}">
                                                    <div class="help-block"></div>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-md-2">
                                                    {{__('package::dashboard.packages.form.video_cv')}}
                                                </label>
                                                <div class="col-md-9">
                                                    <input type="checkbox" class="ischecked" name="video_cv[{{$subcription['id']}}]" value="1" onclick="AcceptVideoCv({{$subcription['id']}})" {{ $subcription->video_cv == 1 ? 'checked' : '' }}>
                                                    <input type="hidden" class="isUnchecked" name="video_cv[{{$subcription['id']}}]" value="0" {{( $subcription->video_cv == 1) ? 'disabled' : ''}}>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-md-2">
                                                    {{__('package::dashboard.packages.form.company_in_home')}}
                                                </label>
                                                <div class="col-md-9">
                                                    <input type="checkbox" class="ischecked" name="company_in_home[{{$subcription['id']}}]" value="1" onclick="CompanyInHome({{$subcription['id']}})" {{ $subcription->company_in_home == 1 ? 'checked' : '' }}>
                                                    <input type="hidden" class="isUnchecked" name="company_in_home[{{$subcription['id']}}]" value="0" {{( $subcription->company_in_home == 1 ) ? 'disabled' : ''}}>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-md-2">
                                                    {{__('package::dashboard.packages.form.is_paid')}}
                                                </label>
                                                <div class="col-md-9">
                                                    <input type="checkbox" class="ischecked" name="is_paid[{{$subcription['id']}}]" value="1" onclick="PaidSubscription({{$subcription['id']}})" {{ $subcription->is_paid == 1 ? 'checked' : '' }}>
                                                    <input type="hidden" class="isUnchecked" name="is_paid[{{$subcription['id']}}]" value="0" {{( $subcription->is_paid == 1 ) ? 'disabled' : ''}}>
                                                </div>
                                            </div>

                                            <hr>

                                        @endforeach


                                    </div>
                                    {{-- PAGE ACTION --}}
                                    <div class="col-md-12">
                                        <div class="form-actions">
                                            @include('apps::dashboard.layouts._ajax-msg')
                                            <div class="form-group">
                                                <button type="submit" id="submit_update_subscription" class="btn btn-lg green">
                                                    {{__('edit current subscription')}}
                                                </button>
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
@stop

@section('scripts')

    <script>

        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
            startDate: '0d'
        });

        $(".package_").change(function() {
            $('#subscription_form').remove();
        });


        function AcceptVideoCv(id){

            $('[name="video_cv['+id+']"]').change(function(){
                if($(this).is(':checked'))
                    $(this).next().prop('disabled', true);
                else
                    $(this).next().prop('disabled', false);
            });

        }

        function CompanyInHome(id){

            $('[name="company_in_home['+id+']"]').change(function(){
                if($(this).is(':checked'))
                    $(this).next().prop('disabled', true);
                else
                    $(this).next().prop('disabled', false);
            });

        }


        function PaidSubscription(id){

            $('[name="is_paid['+id+']"]').change(function(){
                if($(this).is(':checked'))
                    $(this).next().prop('disabled', true);
                else
                    $(this).next().prop('disabled', false);
            });

        }
    </script>

    <script>
        $('#package').on('change', function() {

            var url = '{{ route("dashboard.subscriptions.getlevels", ":id") }}';
            url = url.replace(':id', this.value);

            $.ajax({
                url: url,
                type: 'GET',

                beforeSend: function () {
                    $('#prices').text('');
                    $('#loader').show();
                },
                success: function (data) {

                    $('#loader').hide();
                    $('#prices').text('').append(data.html);
                    // $('#prices').select2();

                },
                error: function (data) {
                    $('#loader').hide();
                }
            });
        });
    </script>

    <script>
        // Update
        $('#update_subscription').on('submit',function(e) {

            e.preventDefault();
            tinyMCE.triggerSave();

            var url     = $(this).attr('action');
            var method  = $(this).attr('method');
            if (window.editors == undefined) {
                $.each(editors, function (index, editor) {
                    editor.updateSourceElement()
                });
            }
            $.ajax({

                xhr: function() {
                    var xhr = new window.XMLHttpRequest();
                    xhr.upload.addEventListener("progress", function(evt) {
                        if (evt.lengthComputable) {
                            var percentComplete = evt.loaded / evt.total;
                            percentComplete = parseInt(percentComplete * 100);
                            $('.progress-bar').width(percentComplete+'%');
                            $('#progress-status').html(percentComplete+'%');
                        }
                    }, false);
                    return xhr;
                },

                url: url,
                type: method,
                dataType: 'JSON',
                data:  new FormData(this),
                contentType: false,
                cache: false,
                processData:false,

                beforeSend : function(){
                    $('#submit_update_subscription').prop('disabled',true);
                    $('.progress-info').show();
                    $('.progress-bar').width('0%');
                    resetErrors();
                },
                success:function(data){
                    $('#submit_update_subscription').prop('disabled',false);
                    $('#submit_update_subscription').text();

                    if (data[0] == true){
                        successfully(data);
                    }else{
                        displayMissing(data);
                    };
                },
                error: function(data){
                    $('#submit_update_subscription').prop('disabled',false);
                    displayErrors(data);
                },
            });

        });
    </script>
@stop

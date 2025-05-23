@extends('apps::dashboard.layouts.app')
@section('title', __('company::dashboard.companies.routes.create'))
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
                    <a href="#">{{__('company::dashboard.companies.routes.create')}}</a>
                </li>
            </ul>
        </div>

        <h1 class="page-title"></h1>

        <div class="row">
            <form id="form" role="form" class="form-horizontal form-row-seperated" method="post" enctype="multipart/form-data" action="{{route('dashboard.companies.store')}}">
                @csrf
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

                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-9">
                        <div class="tab-content">
                            <div class="tab-pane active fade in" id="global_setting">
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
                                                    <input type="text" name="title[{{$code}}]" class="form-control" data-name="title.{{$code}}" {{ (is_rtl($code) == 'rtl') ? 'dir=rtl' : '' }}>
                                                    <div class="help-block"></div>
                                                </div>
                                            </div>

                                        </div>
                                        @endforeach
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-2">
                                            {{__('company::dashboard.companies.form.users')}}
                                        </label>
                                        <div class="col-md-9">
                                            <select name="users[]" class="form-control select2" data-name="users" multiple>
                                                <option value=""></option>
                                                @foreach ($users as $user)
                                                    <option value="{{$user['id']}}">
                                                        {{ $user['id'] }} - {{ $user['name'] }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div class="help-block"></div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-2">
                                            {{__('company::dashboard.companies.form.package')}}
                                        </label>
                                        <div class="col-md-9">
                                            <select name="package" class="form-control select2" id="package" data-name="package">
                                                <option value=""></option>
                                                @foreach ($packages as $package)
                                                    <option value="{{$package['id']}}">
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
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-2">
                                            {{__('company::dashboard.companies.form.state')}}
                                        </label>
                                        <div class="col-md-9">
                                            <select name="state_id" id="single" data-name="state_id" class="form-control select2-allow-clear" multiple>
                                                <option value=""></option>
                                                @foreach ($cities as $city)
                                                <optgroup label="{{ $city->translate(locale())->title }}">
                                                    @foreach ($city->states as $state)
                                                    <option value="{{ $state['id'] }}">
                                                        {{ $state->translate(locale())->title }}
                                                    </option>
                                                    @endforeach
                                                </optgroup>
                                                @endforeach
                                            </select>
                                            <div class="help-block"></div>
                                        </div>
                                    </div>

                                    {!! field()->file('image', __('company::dashboard.companies.form.image')) !!}
                                    <div class="form-group">
                                        <label class="col-md-2">
                                            {{__('company::dashboard.companies.form.status')}}
                                        </label>
                                        <div class="col-md-9">
                                            <input type="checkbox" class="make-switch" id="test" data-size="small" name="status">
                                            <div class="help-block"></div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-actions">
                            @include('apps::dashboard.layouts._ajax-msg')
                            <div class="form-group">
                                <button type="submit" id="submit" class="btn btn-lg blue">
                                    {{__('apps::dashboard.buttons.add')}}
                                </button>
                                <a href="{{url(route('dashboard.companies.index')) }}" class="btn btn-lg red">
                                    {{__('apps::dashboard.buttons.back')}}
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>
@stop
@push('scripts')
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
@endpush
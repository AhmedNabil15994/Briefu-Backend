@extends('apps::dashboard.layouts.app')
@section('title', __('course::dashboard.courses.routes.update'))
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
                    <a href="{{ url(route('dashboard.courses.index')) }}">
                        {{__('course::dashboard.courses.routes.index')}}
                    </a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <a href="#">{{__('course::dashboard.courses.routes.update')}}</a>
                </li>
            </ul>
        </div>

        <h1 class="page-title"></h1>

        <div class="row">
            <form id="updateForm" page="form" class="form-horizontal form-row-seperated" method="post" enctype="multipart/form-data" action="{{route('dashboard.courses.update',$course->id)}}">
                @csrf
                @method('PUT')
                <div class="col-md-12">

                    {{-- RIGHT SIDE --}}
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
                                                    {{ __('course::dashboard.courses.form.tabs.general') }}
                                                </a>
                                            </li>
                                            {{-- <li>
                                                <a href="#seo" data-toggle="tab">
                                                    {{ __('course::dashboard.courses.form.tabs.seo') }}
                                            </a>
                                            </li> --}}
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- PAGE CONTENT --}}
                    <div class="col-md-9">
                        <div class="tab-content">

                            {{-- UPDATE FORM --}}
                            <div class="tab-pane active fade in" id="global_setting">
                                <h3 class="page-title">{{__('course::dashboard.courses.form.tabs.general')}}</h3>
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
                                                    {{__('course::dashboard.courses.form.title')}}
                                                </label>
                                                <div class="col-md-9">
                                                    <input type="text" name="title[{{$code}}]" class="form-control" data-name="title.{{$code}}" value="{{ $course->translate($code)->title }}" {{ (is_rtl($code) == 'rtl') ? 'dir=rtl' : '' }}>
                                                    <div class="help-block"></div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-2">
                                                    {{__('course::dashboard.courses.form.description')}} - {{ $code }}
                                                </label>
                                                <div class="col-md-9">
                                                    <textarea name="description[{{$code}}]" rows="8" cols="80" class="form-control {{is_rtl($code)}}Editor" data-name="description.{{$code}}">{{ $course->translate($code)->description }}</textarea>
                                                    <div class="help-block"></div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-2">
                                            {{__('job::dashboard.jobs.form.company')}}
                                        </label>
                                        <div class="col-md-9">
                                            <select name="company_id" class="form-control select2" data-name="company">
                                                <option value=""></option>
                                                @foreach ($companies as $company)
                                                    <option value="{{$company['id']}}" {{ $course->company_id == $company->id ? 'selected' : '' }}>
                                                        {{ $company['id'] }} - {{ $company->translate(locale())->title }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div class="help-block"></div>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label class="col-md-2">
                                            {{__('course::dashboard.courses.form.categories')}}
                                        </label>
                                        <div class="col-md-9">
                                            <select name="categories[]" class="form-control select2" data-name="categories" multiple>
                                                <option value=""></option>
                                                @foreach ($categories as $category)
                                                    <option value="{{$category['id']}}" {{ $course->categories->contains($category->id) ? 'selected' : '' }}>
                                                        {{ $category['id'] }} - {{ $category->translate(locale())->title }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div class="help-block"></div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-2">
                                            {{__('course::dashboard.courses.form.price')}}
                                        </label>
                                        <div class="col-md-9">
                                            <input type="text" name="price" class="form-control" data-name="price" value="{{ $course->price }}">
                                            <div class="help-block"></div>
                                        </div>
                                    </div>


                                    {!! field()->file('image',__('course::dashboard.courses.form.image'),$course->image ? url($course->image) : null) !!}

                                    <div class="form-group">
                                        <label class="col-md-2">
                                            {{__('course::dashboard.courses.form.status')}}
                                        </label>
                                        <div class="col-md-9">
                                            <input type="checkbox" class="make-switch" id="test" data-size="small" name="status" {{($course->status == 1) ? ' checked="" ' : ''}}>
                                            <div class="help-block"></div>
                                        </div>
                                    </div>

                                    @if ($course->trashed())
                                    <div class="form-group">
                                        <label class="col-md-2">
                                            {{__('course::dashboard.courses.form.restore')}}
                                        </label>
                                        <div class="col-md-9">
                                            <input type="checkbox" class="make-switch" id="test" data-size="small" name="restore">
                                            <div class="help-block"></div>
                                        </div>
                                    </div>
                                    @endif

                                </div>
                            </div>

                            {{-- PAGE ACTION --}}
                            <div class="col-md-12">
                                <div class="form-actions">
                                    @include('apps::dashboard.layouts._ajax-msg')
                                    <div class="form-group">
                                        <button type="submit" id="submit" class="btn btn-lg green">
                                            {{__('apps::dashboard.buttons.edit')}}
                                        </button>
                                        <a href="{{url(route('dashboard.courses.index')) }}" class="btn btn-lg red">
                                            {{__('apps::dashboard.buttons.back')}}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@stop

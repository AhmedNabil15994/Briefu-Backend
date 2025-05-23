@extends('apps::dashboard.layouts.app')
@section('title', __('job::dashboard.jobs.routes.show'))
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
                    <a href="{{ url(route('dashboard.jobs.index')) }}">{{__('job::dashboard.jobs.routes.index')}}</a>
					<i class="fa fa-circle"></i>
                </li>

                <li>
                    <a href="#">{{__('job::dashboard.jobs.routes.show')}}</a>
                </li>

            </ul>
        </div>

        <h1 class="page-title"></h1>

        <div class="row">

            <div class="col-md-12">

                <div class="search-page">
                    <div class="row">

                        <div class="col-lg-4">
                            <div class="search-filter ">
                                <div class="search-label uppercase">Search By</div>
                                <form action="{{ url(route('dashboard.jobs.show',$job->id)) }}" method="GET">
                                    @foreach ($targets as $key => $target)
                                        <div class="search-label uppercase">
                                            {{ $target->translate(locale())->title }}
                                        </div>
                                        <select name="attribute_values[{{ $target['id'] }}]" id="single" class="form-control select2" multiple>
                                            @foreach ($target->values as $value)
                                            <option value="{{ $value['id'] }}">
                                                {{ $value->translate(locale())->title }}
                                            </option>
                                            @endforeach
                                        </select>
                                    @endforeach

                                        <div class="search-label uppercase">
                                            {{ __('job::dashboard.jobs.filter.status') }}
                                        </div>
{{--                                        {{dd((array)request('cv_status'))}}--}}
                                        <select name="cv_status" class="form-control select2" multiple>
                                            @foreach (\Modules\Job\Entities\JobUser::getOptionsForSelect() as $key => $value)
                                                <option value="{{ $key }}" {{in_array($key,(array)request('cv_status'))?'selected' : ''}}>
                                                    {{ $value }}
                                                </option>
                                            @endforeach
                                        </select>
                                    <button type="submit" class="btn green bold uppercase btn-block">Filter</button>
                                    <div class="search-filter-divider bg-grey-steel"></div>
                                </form>

                            </div>
                        </div>

                        <div class="col-lg-8">
                            <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                                <thead>
                                    <tr>
                                        <th> # </th>
                                        <th> ID  </th>
                                        <th> Name </th>
                                        <th> Email </th>
                                        <th> Mobile </th>
                                        <th> Status </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($cvs as $key => $cv)
                                        <tr class="odd gradeX">
                                            <td class="center"> <img src="{{ asset(optional($cv->user)->image) }}" alt="" width="50%"> </td>
                                            <td class="center"> {{ optional($cv->user)->id}} </td>
                                            <td class="center"> {{ optional($cv->user)->name }}</td>
                                            <td class="center"> {{ optional(optional($cv->user)->profileCv)->email }} </td>
                                            <td class="center"> {{ optional(optional($cv->user)->profileCv)->mobile }} </td>
                                            <td class="center"> {{ \Modules\Job\Entities\JobUser::getOptionsForSelect()[$cv->status] }} </td>
                                            <td class="center">
                                                <a href="{{ route("dashboard.cvs.show",[optional($cv->user)->id,$job->id]) }}" class="btn btn-sm btn-warning" title="Show">
                                                  <i class="fa fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>

@stop

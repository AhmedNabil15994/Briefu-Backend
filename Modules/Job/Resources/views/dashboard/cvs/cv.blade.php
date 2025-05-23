@extends('apps::dashboard.layouts.app')
@section('title', __('job::dashboard.cvs.routes.show'))
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

				<div class="profile-sidebar">

					<div class="portlet light profile-sidebar-portlet ">

						<div class="profile-userpic">
							<img src="{{ asset($cv->image) }}" class="img-responsive" alt="">
						</div>

						<div class="profile-usertitle">
							<div class="profile-usertitle-name"> {{ $cv->name }} </div>
						</div>

					</div>

					<div class="portlet light ">

						<div class="row list-separated profile-stat">
							<div class="col-md-4 col-sm-4 col-xs-6">
								<div class="uppercase profile-stat-text"> {{ $cv->profileCv->qualification->translate(locale())->title }} /  {{ $cv->profileCv->graduate_year }} </div>
							</div>
							<div class="col-md-4 col-sm-4 col-xs-6">
								<div class="uppercase profile-stat-text"> {{ $cv->profileCv->faculty }} </div>
							</div>
							<div class="col-md-4 col-sm-4 col-xs-6">
								<div class="uppercase profile-stat-text"> {{ $cv->profileCv->major }} </div>
							</div>
						</div>

						<div>
							<h4 class="profile-desc-title">{{ $cv->profileCv->gender }}</h4>
						</div>
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
                                            {{__('job::dashboard.cvs.form.courses')}}
										</span>
									</div>
								</div>
								<div class="portlet-body">
									<div class="table-scrollable table-scrollable-borderless">
										<table class="table table-hover table-light">
											<thead>
												<tr class="uppercase">
													<th colspan="2"> {{__('job::dashboard.cvs.form.courses')}} </th>
													<th colspan="2"> {{__('job::dashboard.cvs.form.address')}} </th>
													<th colspan="2"> {{__('job::dashboard.cvs.form.hrs')}} </th>
													<th colspan="2"> {{__('job::dashboard.cvs.form.from')}} </th>
												</tr>
											</thead>
											@foreach ($cv->certifications as $key => $certificat)
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
                                            {{__('job::dashboard.cvs.form.experiences')}}
										</span>
									</div>
								</div>
								<div class="portlet-body">
									<div class="table-scrollable table-scrollable-borderless">
										<table class="table table-hover table-light">
											<thead>
												<tr class="uppercase">
													<th colspan="2"> {{__('job::dashboard.cvs.form.company')}} </th>
													<th colspan="2"> {{__('job::dashboard.cvs.form.company_address')}}</th>
													<th colspan="2"> {{__('job::dashboard.cvs.form.position')}} </th>
													<th colspan="2"> {{__('job::dashboard.cvs.form.from')}} </th>
													<th colspan="2"> {{__('job::dashboard.cvs.form.to')}} </th>
												</tr>
											</thead>
											@foreach ($cv->experiences as $key => $experience)
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
                                            {{__('job::dashboard.cvs.form.target')}}
										</span>
									</div>
								</div>
								<div class="portlet-body">
									<div class="table-scrollable table-scrollable-borderless">
										<table class="table table-hover table-light">
											@foreach ($cv->target as $key => $target)
												<tr>
                                                    <td> {{ $target->attribute->translate(locale())->title }} : </td>
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
											{{__('job::dashboard.cvs.form.video_cv')}}
										</span>
									</div>
								</div>
								<div class="portlet-body">
									<div class="table-scrollable table-scrollable-borderless">
										<a class="btn btn-lg green hidden-print margin-bottom-5">
					                        {{__('job::dashboard.cvs.form.open')}}
					                    </a>
									</div>
								</div>
							</div>
							<!-- END PORTLET -->
						</div>


					</div>

				</div>

			</div>

		</div>

    </div>
</div>

@stop

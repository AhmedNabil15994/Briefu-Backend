@extends('apps::dashboard.layouts.app')
@section('title', __('course::dashboard.course_orders.routes.show'))
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

				<div class="profile-sidebar">

					<div class="portlet light profile-sidebar-portlet ">

						<div class="profile-userpic">
							<img src="{{ url($order->image) }}" class="img-responsive" alt="">
						</div>

						<div class="profile-usertitle">
							<div class="profile-usertitle-name"> {{ $order->name }} </div>
						</div>

					</div>

					<div class="portlet light ">

						<div class="row list-separated profile-stat">
							<div class="col-md-4 col-sm-4 col-xs-6">
								<div class="uppercase profile-stat-text"> {{ $order->profileCv->qualification->translate(locale())->title }} /  {{ $order->profileCv->graduate_year }} </div>
							</div>
							<div class="col-md-4 col-sm-4 col-xs-6">
								<div class="uppercase profile-stat-text"> {{ $order->profileCv->faculty }} </div>
							</div>
							<div class="col-md-4 col-sm-4 col-xs-6">
								<div class="uppercase profile-stat-text"> {{ $order->profileCv->major }} </div>
							</div>
						</div>

						<div>
							<h4 class="profile-desc-title">{{ $order->profileCv->gender }}</h4>
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
											@foreach ($order->certifications as $key => $certificat)
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
											@foreach ($order->experiences as $key => $experience)
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
											@foreach ($order->target as $key => $target)
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
											{{__('course::dashboard.course_orders.form.video_cv')}}
										</span>
									</div>
								</div>
								<div class="portlet-body">
									<div class="table-scrollable table-scrollable-borderless">
										<a class="btn btn-lg green hidden-print margin-bottom-5">
					                        {{__('course::dashboard.course_orders.form.open')}}
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

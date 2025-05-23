

@push('styles')
<style>
    .table.table-light>tbody>tr>td {
        color: #2b3643;
    }
    .table.table-light>thead>tr>th {
        font-weight: 600;
        font-size: 13px;
        color: #2b3643;
        border: 0;
        border-bottom: 1px solid #F2F5F8;
    }
    .profile-desc-title {
        color: #2b3643;
        font-weight: 600;
    }
    .font-blue-madison {
        color: #045296!important;
    }
    .portlet.light {
        padding: 12px 20px 15px;
        background-color: #fafcff;
        border-radius: 6px;
        border: 1px solid #ddd;
    }

</style>
@endpush
<div class="tab-pane active" id="cvs">
    <div class="invoice-content-2 bcvsed">

        <div class="profile-sidebar">

            <div class="portlet light profile-sidebar-portlet ">

                <div class="profile-userpic">
                    <img style="    border-radius: 1%!important;" src="{{ asset($user->image) }}" class="img-responsive" alt="">
                </div>

                <div class="profile-usertitle">
                    <div class="profile-usertitle-name"> {{ $user->name }} </div>
                </div>

            </div>

            <div class="portlet light ">

                <div>
                    <label class="caption-subject font-blue-madison bold ">{{__('job::dashboard.cvs.form.mobile')}} :</label>
                    <span class="profile-desc-title" style="font-size: 13px;">{{ optional($user->profileCv)->mobile }}</span>
                </div>
                <div>
                    <label class="caption-subject font-blue-madison bold ">{{__('job::dashboard.cvs.form.email')}} :</label>
                    <span class="profile-desc-title" style="font-size: 13px;">{{ optional($user->profileCv)->email }}</span>
                </div>
                <div>
                    <label class="caption-subject font-blue-madison bold ">{{__('job::dashboard.cvs.form.nationality')}} :</label>
                    <span class="profile-desc-title" style="font-size: 13px;">{{ optional($user->nationality)->title }}</span>
                </div>
                <div>
                    <label class="caption-subject font-blue-madison bold ">{{__('job::dashboard.cvs.form.country_of_residence')}} :</label>
                    <span class="profile-desc-title" style="font-size: 13px;">{{ optional(optional(optional($user->profileCv)->country)->translate(locale()))->title }}</span>
                </div>
                <div>
                    <label class="caption-subject font-blue-madison bold ">{{__('job::dashboard.cvs.form.gender')}} :</label>
                    <span class="profile-desc-title" style="font-size: 13px;">{{ optional($user->profileCv)->gender_trans }}</span>
                </div>
                <div>
                    <label class="caption-subject font-blue-madison bold ">{{__('job::dashboard.cvs.form.marital_status')}} :</label>
                    <span class="profile-desc-title" style="font-size: 13px;">{{ optional($user->profileCv)->marital_status_trans }}</span>
                </div>
                <div>
                    <label class="caption-subject font-blue-madison bold ">{{__('job::dashboard.cvs.form.b_day')}} :</label>
                    <span class="profile-desc-title" style="font-size: 13px;">{{ optional($user->profileCv)->b_day }}</span>
                </div>
                <div>
                    <label class="caption-subject font-blue-madison bold ">{{__('job::dashboard.cvs.form.is_special')}} :</label>
                    <span class="profile-desc-title" style="font-size: 13px;">{{ $user->is_special ? __('job::dashboard.cvs.form.yes') : __('job::dashboard.cvs.form.no') }}</span>
                </div>
                <hr>
                <div>
                    
                    <label class="caption-subject font-blue-madison bold ">{{__('job::dashboard.cvs.form.graduation_info')}}</label>
                    <br>
                    
                    <div>
                        <label class="caption-subject font-blue-madison bold ">{{__('job::dashboard.cvs.form.qualification')}} :</label>
                        <span class="profile-desc-title" style="font-size: 13px;">
                            {{ optional(optional(optional(optional($user)->profileCv)->qualification)->translate(locale()))->title }}
                        </span>
                    </div>
                    
                    <div>
                        <label class="caption-subject font-blue-madison bold ">{{__('job::dashboard.cvs.form.fresh_graduate')}} :</label>
                        <span class="profile-desc-title" style="font-size: 13px;">
                            {{ __('job::dashboard.cvs.form.'.(optional(optional($user)->profileCv)->is_fresh_graduate != 1 ? 'no' : 'yes')) }}
                        </span>
                    </div>
                    
                    <div>
                        <label class="caption-subject font-blue-madison bold ">{{__('job::dashboard.cvs.form.graduate_year')}} :</label>
                        <span class="profile-desc-title" style="font-size: 13px;">
                            {{ optional($user->profileCv)->graduate_year }}
                        </span>
                    </div>
                    
                    <div>
                        <label class="caption-subject font-blue-madison bold ">{{__('job::dashboard.cvs.form.faculty')}} :</label>
                        <span class="profile-desc-title" style="font-size: 13px;">
                            {{ optional($user->profileCv)->faculty }}
                        </span>
                    </div>
                    
                    <div>
                        <label class="caption-subject font-blue-madison bold ">{{__('job::dashboard.cvs.form.major')}} :</label>
                        <span class="profile-desc-title" style="font-size: 13px;">
                            {{ optional($user->profileCv)->major }} 
                        </span>
                    </div>
                    
                    {{-- <div>
                        <label class="caption-subject font-blue-madison bold ">{{__('job::dashboard.cvs.form.address_from')}} :</label>
                        <span class="profile-desc-title" style="font-size: 13px;">
                            {{ optional(optional($user->profileCv)->country)->title }} ,
                            {{ optional(optional($user->profileCv)->state)->title }}
                        </span>
                    </div> --}}
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
                                <span class="caption-subject font-blue-madison bold ">
								                            {{__('job::dashboard.cvs.form.courses')}}
								                        </span>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="table-scrollable table-scrollable-borderless">
                                <table class="table table-hover table-light">
                                    <thead>
                                        <tr class="">
                                            <th colspan="2"> {{__('job::dashboard.cvs.form.courses')}} </th>
                                            <th colspan="2"> {{__('job::dashboard.cvs.form.address')}} </th>
                                        </tr>
                                    </thead>
                                    @foreach ($user->certifications()->orderBy('order','asc')->get() as $key => $certificat)
                                        <tr>
                                            <td colspan="2"> {{ $certificat->certificat }} </td>
                                            <td colspan="2"> {{ $certificat->address }} </td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- END PORTLET -->
                </div>

                @if($user->experiences()->count())
                    <div class="col-md-12">
                        <!-- BEGIN PORTLET -->
                        <div class="portlet light ">
                            <div class="portlet-title">
                                <div class="caption caption-md">
                                    <i class="icon-bar-chart theme-font hide"></i>
                                    <span class="caption-subject font-blue-madison bold ">
                                                                {{__('job::dashboard.cvs.form.experiences')}}
                                                            </span>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div class="table-scrollable table-scrollable-borderless">
                                    <table class="table table-hover table-light">
                                        <thead>
                                        <tr class="">
                                            <th colspan="2"> {{__('job::dashboard.cvs.form.position')}} </th>
                                            <th colspan="2"> {{__('job::dashboard.cvs.form.company')}} </th>
                                            <th colspan="2"> {{__('job::dashboard.cvs.form.from')}} </th>
                                            <th colspan="2"> {{__('job::dashboard.cvs.form.to')}} </th>
                                            <th colspan="2"> {{__('job::dashboard.cvs.form.company_address')}}</th>
                                        </tr>
                                        </thead>
                                        @foreach ($user->experiences()->orderBy('from','desc')->get() as $key => $experience)
                                            <tr>
                                                <td colspan="2"> {{ $experience->position }} </td>
                                                <td colspan="2"> {{ $experience->company }} </td>
                                                <td colspan="2"> {{ $experience->from }} </td>
                                                <td colspan="2"> {{ is_null($experience->to) ? __('job::dashboard.cvs.form.until_now') : $experience->to }} </td>
                                                <td colspan="2"> {{ $experience->company_address }} </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- END PORTLET -->
                    </div>
                @endif

                <div class="col-md-12">
                    <!-- BEGIN PORTLET -->
                    <div class="portlet light ">
                        <div class="portlet-title">
                            <div class="caption caption-md">
                                <i class="icon-bar-chart theme-font hide"></i>
                                <span class="caption-subject font-blue-madison bold ">
								                            {{__('job::dashboard.cvs.form.target')}}
								                        </span>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="table-scrollable table-scrollable-borderless">
                                <table class="table table-hover table-light">
                                    @foreach ($user->target as $key => $target)
                                        <tr>
                                            <td> {{ $target->attribute->translate(locale())->title }}
                                                :
                                            </td>
                                            <td> {{ $target->translate(locale())->title }} </td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- END PORTLET -->
                </div>

                <div class="col-md-6">
                    <!-- BEGIN PORTLET -->
                    <div class="portlet light ">
                        <div class="portlet-title">
                            <div class="caption caption-md">
                                <i class="icon-bar-chart theme-font hide"></i>
                                <span class="caption-subject font-blue-madison bold ">
								                            {{__('job::dashboard.cvs.form.video_cv')}}
								                        </span>
                            </div>
                        </div>
                        @if(optional($user)->cv_video_path)
                            <div class="portlet-body">
                                <div class="table-scrollable table-scrollable-borderless">
                                    <a class="btn btn-lg green hidden-print margin-bottom-5"
                                       href="{{Storage::disk('s3')->url(optional($user)->cv_video_path)}}">
                                        {{__('job::dashboard.cvs.form.open')}}
                                    </a>
                                </div>
                            </div>
                        @else
                            <div class="alert alert-danger text-center" role="alert">
                                {{__('job::dashboard.cvs.form.not_have_video')}}
                            </div>
                        @endif
                    </div>
                </div>

                <div class="col-md-6">
                    <!-- BEGIN PORTLET -->
                    <div class="portlet light ">
                        <div class="portlet-title">
                            <div class="caption caption-md">
                                <i class="icon-bar-chart theme-font hide"></i>
                                <span class="caption-subject font-blue-madison bold ">
								                            {{__('job::dashboard.cvs.form.pdf_cv')}}
								                        </span>
                            </div>
                        </div>
                        @if(optional(optional($user)->profileCv)->cv_pdf)
                            <div class="portlet-body">
                                <div class="table-scrollable table-scrollable-borderless">
                                    <a class="btn btn-lg green hidden-print margin-bottom-5"
                                       href="{{asset(optional(optional($user)->profileCv)->cv_pdf)}}">
                                        {{__('job::dashboard.cvs.form.open_pdf')}}
                                    </a>
                                </div>
                            </div>
                        @else
                            <div class="alert alert-danger text-center" role="alert">
                                {{__('job::dashboard.cvs.form.not_have_pdf')}}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
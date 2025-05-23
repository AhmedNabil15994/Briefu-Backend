@extends('apps::dashboard.layouts.app')
@section('title', __('coupon::dashboard.coupons.routes.update'))
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
                        <a href="{{ url(route('dashboard.coupons.index')) }}">
                            {{__('coupon::dashboard.coupons.routes.index')}}
                        </a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <a href="#">{{__('coupon::dashboard.coupons.routes.update')}}</a>
                    </li>
                </ul>
            </div>

            <h1 class="page-title"></h1>

            <div class="row">
                <form id="updateForm" page="form" class="form-horizontal form-row-seperated" method="post"
                      enctype="multipart/form-data" action="{{route('dashboard.coupons.update',$coupon->id)}}">
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
                                                        {{ __('coupon::dashboard.coupons.form.tabs.general') }}
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- PAGE CONTENT --}}
                        <div class="col-md-9">
                            <div class="tab-content">

                                {{-- CREATE FORM --}}

                                <div class="tab-pane active fade in" id="global_setting">
                                    <h3 class="page-title">{{__('coupon::dashboard.coupons.form.tabs.general')}}</h3>
                                    <div class="col-md-10">

                                        <div>
                                            <div class="tabbable">
                                                <ul class="nav nav-tabs bg-slate nav-tabs-component">
                                                    @foreach (config('laravellocalization.supportedLocales') as $code => $lang)
                                                        <li class=" {{ ($code == locale()) ? 'active' : '' }}">
                                                            <a href="#colored-rounded-tab-seo-{{$code}}" data-toggle="tab" aria-expanded="false"> {{ $lang['native'] }}
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>

                                            <div class="tab-content">
                                                @foreach (config('translatable.locales') as $code)
                                                    <div class="tab-pane @if($code==app()->getLocale()) active @endif"
                                                         id="colored-rounded-tab-seo-{{$code}}">
                                                        <div class="form-group">
                                                            <label class="col-md-2">
                                                                {{__('coupon::dashboard.coupons.form.title')}}
                                                            </label>
                                                            <div class="col-md-9">
                                                                <input type="text" name="title[{{$code}}]"
                                                                       class="form-control" data-name="title.{{$code}}"
                                                                       value="{{$coupon->getTranslation('title',$code)}}">
                                                                <div class="help-block"></div>
                                                            </div>
                                                        </div>

                                                    </div>

                                                @endforeach
                                            </div>
                                            <hr>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{__('coupon::dashboard.coupons.form.code')}}
                                            </label>
                                            <div class="col-md-9">
                                                <input type="text" name="code" value="{{$coupon->code}}"
                                                       class="form-control" data-name="code">
                                                <div class="help-block"></div>
                                            </div>
                                        </div>

                                        <div class="form-group discount_type" id="percentage">
                                            <label class="col-md-2">
                                                {{__('coupon::dashboard.coupons.form.discount_percentage')}} %
                                            </label>
                                            <div class="col-md-9">
                                                <input type="number" name="discount_percentage"
                                                       value="{{$coupon->discount_percentage}}" class="form-control"
                                                       data-name="discount_percentage">
                                                <div class="help-block"></div>
                                            </div>
                                        </div> 
                                        
                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{__('coupon::dashboard.coupons.form.start_at')}}
                                            </label>
                                            <div class="col-md-9">
                                                <div class="input-group input-medium date time date-picker"
                                                     data-date-format="yyyy-mm-dd" data-date-start-date="+0d">
                                                    <input type="text" id="offer-form" class="form-control"
                                                           name="start_at" value="{{$coupon->start_at}}"
                                                           data-name="start_at">
                                                    <span class="input-group-btn">
                                                        <button class="btn default" type="button">
                                                            <i class="fa fa-calendar"></i>
                                                        </button>
                                                    </span>
                                                </div>
                                                <div class="help-block"></div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{__('coupon::dashboard.coupons.form.expired_at')}}
                                            </label>
                                            <div class="col-md-9">
                                                <div class="input-group input-medium date time date-picker"
                                                     data-date-format="yyyy-mm-dd" data-date-start-date="+0d">
                                                    <input type="text" id="offer-form" class="form-control"
                                                           name="expired_at" value="{{$coupon->expired_at}}"
                                                           data-name="expired_at">
                                                    <span class="input-group-btn">
                                                        <button class="btn default" type="button">
                                                            <i class="fa fa-calendar"></i>
                                                        </button>
                                                    </span>
                                                </div>
                                                <div class="help-block"></div>
                                            </div>
                                        </div>

                                        @inject('subscripitons','Modules\Subscription\Entities\Subscription')
                                        {!! field()->multiSelect('subscriptions', 
                                        __('coupon::dashboard.coupons.form.subscriptions'),
                                        $subscripitons->pluck('title','id')->toArray(),
                                        $coupon->subscriptions()->count() ? $coupon->subscriptions->pluck('id')->toArray() : null,
                                        ['data-placeholder' => __('coupon::dashboard.coupons.form.all_subscriptions')]) !!}

                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{__('coupon::dashboard.coupons.form.status')}}
                                            </label>
                                            <div class="col-md-9">
                                                <input type="checkbox" class="make-switch" id="test" data-size="small"
                                                       name="status" {{($coupon->status == 1) ? ' checked="" ' : ''}}>
                                                <div class="help-block"></div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{__('coupon::dashboard.coupons.form.special_clients')}}
                                            </label>
                                            <div class="col-md-9">
                                                <input type="checkbox" class="make-switch" id="special_clients_only" data-size="small"
                                                       name="special_clients_only" {{($coupon->special_clients_only == 1) ? ' checked="" ' : ''}}>
                                                <div class="help-block"></div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                {{-- END CREATE FORM --}}
                            </div>
                        </div>

                        {{-- PAGE ACTION --}}
                        <div class="col-md-12">
                            <div class="form-actions">
                                @include('apps::dashboard.layouts._ajax-msg')
                                <div class="form-group">
                                    <button type="submit" id="submit" class="btn btn-lg green">
                                        {{__('apps::dashboard.buttons.add')}}
                                    </button>
                                    <a href="{{url(route('dashboard.coupons.index')) }}" class="btn btn-lg red">
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

@section('scripts')
    <script>

        $('#{{$coupon->discount_type}}').show();

        $(function () {    // Makes sure the code contained doesn't run until
            //     all the DOM elements have loaded

            $('#discount_type').change(function () {
                $('.discount_type').hide();
                $('#' + $(this).val()).show();
            });

        });

        function toggleCouponFlag(flag) {
            switch (flag) {
                case 'vendors':
                    $('#vendorsSection').show();
                    $('#categoriesSection').hide();
                    $('#productsSection').hide();
                    break;

                case 'categories':
                    $('#vendorsSection').hide();
                    $('#categoriesSection').show();
                    $('#productsSection').hide();
                    break;

                case 'products':
                    $('#vendorsSection').hide();
                    $('#categoriesSection').hide();
                    $('#productsSection').show();
                    break;

                case '':
                    $('#vendorsSection').hide();
                    $('#categoriesSection').hide();
                    $('#productsSection').hide();
                    break;

                default:
                    break;
            }
        }


    </script>

@endsection

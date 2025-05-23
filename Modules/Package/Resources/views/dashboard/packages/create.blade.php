@extends('apps::dashboard.layouts.app')
@section('title', __('package::dashboard.packages.routes.create'))
@section('content')

@include('package::dashboard.packages.levels')

<div class="page-content-wrapper">
    <div class="page-content">
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <a href="{{ url(route('dashboard.home')) }}">{{ __('apps::dashboard.index.title') }}</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <a href="{{ url(route('dashboard.packages.index')) }}">
                        {{__('package::dashboard.packages.routes.index')}}
                    </a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <a href="#">{{__('package::dashboard.packages.routes.create')}}</a>
                </li>
            </ul>
        </div>

        <h1 class="page-title"></h1>

        <div class="row">
            <form id="form" role="form" class="form-horizontal form-row-seperated" method="post" enctype="multipart/form-data" action="{{route('dashboard.packages.store')}}">
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
                                                    {{ __('package::dashboard.packages.form.tabs.general') }}
                                                </a>
                                            </li>

                                            <li class="">
                                                <a href="#levels" data-toggle="tab">
                                                    {{ __('package::dashboard.packages.form.tabs.levels') }}
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
                                <h3 class="page-title">{{__('package::dashboard.packages.form.tabs.general')}}</h3>
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
                                                    {{__('package::dashboard.packages.form.title')}}
                                                </label>
                                                <div class="col-md-9">
                                                    <input type="text" name="title[{{$code}}]" class="form-control" data-name="title.{{$code}}" {{ (is_rtl($code) == 'rtl') ? 'dir=rtl' : '' }}>
                                                    <div class="help-block"></div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-2">
                                                    {{__('package::dashboard.packages.form.description')}}
                                                </label>
                                                <div class="col-md-9">
                                                    <textarea name="description[{{$code}}]" rows="8" cols="80" class="form-control {{is_rtl($code)}}Editor" data-name="description.{{$code}}"></textarea>
                                                    <div class="help-block"></div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-2">
                                            {{__('package::dashboard.packages.form.is_free')}}
                                        </label>
                                        <div class="col-md-9">
                                            <input type="checkbox" class="make-switch" id="is_free" data-size="small" name="is_free">
                                            <div class="help-block"></div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-2">
                                            {{__('package::dashboard.packages.form.status')}}
                                        </label>
                                        <div class="col-md-9">
                                            <input type="checkbox" class="make-switch" id="test" data-size="small" name="status">
                                            <div class="help-block"></div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="tab-pane fade in" id="levels">
                                <h3 class="page-title">
                                    {{ __('package::dashboard.packages.form.tabs.levels') }}
                                </h3>
                                <div class="col-md-10">

                                    <div class="levels-form"></div>

                                    <div class="form-group">
                                        <button type="button" class="btn green btn-lg mt-ladda-btn ladda-button btn-circle btn-outline add-levels" data-style="slide-down" data-spinner-color="#333">
                                            <span class="ladda-label">
                                                <i class="icon-plus"></i>
                                            </span>
                                        </button>
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
                                <a href="{{url(route('dashboard.packages.index')) }}" class="btn btn-lg red">
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
    // GALLERY FORM / ADD NEW BUTTON UPLOAD
    $(document).ready(function() {
        var html = $("div.get-levels-form").html();

        $(".add-levels").click(function(e) {
            e.preventDefault();
            $(".levels-form").append(html);
            $('.lfm').filemanager('image');
            refreshPriceDisplay();
        });
    });

    $("#is_free").bootstrapSwitch({
        onSwitchChange: function (e, state) {
            if (state)
                $('.price').hide();
            else
                $('.price').show();
        }
    });

    // DELETE UPLOAD BUTTON
    $(".levels-form").on("click", ".delete-levels", function(e) {
        e.preventDefault();
        $(this).closest('.levels-form-html').remove();
    });
</script>

<script>

function refreshPriceDisplay(){

    let state = $("#is_free").bootstrapSwitch('state');
    if (state)
        $('.price').hide();
    else
        $('.price').show();
}

function AcceptVideoCv(){

  $('[name="video_cv[]"]').change(function(){
      if($(this).is(':checked'))
        $(this).next().prop('disabled', true);
      else
        $(this).next().prop('disabled', false);
  });

}

function CompanyInHome(){

  $('[name="company_in_home[]"]').change(function(){
      if($(this).is(':checked'))
        $(this).next().prop('disabled', true);
      else
        $(this).next().prop('disabled', false);
  });

}

</script>

@stop

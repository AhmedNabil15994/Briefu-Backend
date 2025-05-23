@push('styles')
    <style>
        .delete-possibility{
            position: absolute;
            @if(locale() == 'ar') left @else right @endif: 20px;
            color: #ff2841;
            font-size: 19px;    
            z-index: 3;
            cursor: pointer;
        }
    </style>
@endpush
@inject('berTypes','Modules\Subscription\Entities\BerType')
@inject("apple_tiers","Modules\Subscription\Entities\AppleTier")
{!! field()->langNavTabs() !!}

<div class="tab-content">
    @foreach (config('laravellocalization.supportedLocales') as $code => $lang)
        <div class="tab-pane fade in {{ ($code == locale()) ? 'active' : '' }}"
             id="first_{{$code}}">
            {!! field()->text('title['.$code.']',
            __('subscription::dashboard.subscriptions.form.title').'-'.$code ,
                    $model->getTranslation('title' , $code),
                  ['data-name' => 'title.'.$code]
             ) !!}
            {!! field()->text('sub_title['.$code.']',
            __('subscription::dashboard.subscriptions.form.sub_title').'-'.$code ,
                    $model->getTranslation('sub_title' , $code),
                  ['data-name' => 'sub_title.'.$code]
             ) !!}
        </div>
    @endforeach
</div>

{!! field()->select('ber_type_id', __('subscription::dashboard.subscriptions.form.ber_type'),$berTypes->pluck('title','id')->toArray()) !!}
{!! field()->number('ber_numbers', __('subscription::dashboard.subscriptions.form.ber_numbers')) !!}
{!! field()->number('order', __('subscription::dashboard.subscriptions.form.sort')) !!}

@php 
    $accessesIds = $model->possibilities()->whereNull('title')->first();
    $accessesIds = $accessesIds && $accessesIds->accesses()->count() ? $accessesIds->accesses->pluck('access_to')->toArray() : [];
@endphp
{!! field()->multiSelect('access_to' , __('subscription::dashboard.subscriptions.form.access_to'),Modules\Subscription\Entities\Access::accessTypeForSelect(), $accessesIds , [
"class" => "form-control select2"
]) !!}
{!! field()->checkBox('is_free', __('subscription::dashboard.subscriptions.form.is_free')) !!}
<div id="price-content">
    {!! field()->select('apple_tier_id', __('subscription::dashboard.subscriptions.form.apple_tier'), $apple_tiers->pluck("price","id")->toArray()) !!}
    {{-- {!! field()->number('price', __('subscription::dashboard.subscriptions.form.price'),null,['step' => '0.001']) !!} --}}
</div>
{!! field()->checkBox('status', __('subscription::dashboard.subscriptions.form.status')) !!}

<div class="possibilities-form">
    @if($model->possibilities && $model->possibilities()->whereNotNull('title')->count())
        @foreach($model->possibilities()->whereNotNull('title')->get() as $possibility)
            <div class="row delete-content"  style="margin-top: 20px;padding: 16px 11px;box-shadow: 0px 0px 3px 0px #3641503d;">
                <span class="delete-possibility">
                    <i class="fa fa-remove"></i>
                </span>
                @foreach (config('laravellocalization.supportedLocales') as $code => $lang)
                    <div class="col-xs-12">
                        {!! field()->text('title_possibility['.$possibility->id.']['.$code.']',
                        __('subscription::dashboard.subscriptions.form.title').'-'.$code ,
                                $possibility->getTranslation('title' , $code),
                              ['data-name' => 'title.'.$possibility->id.$code]
                         ) !!}
                    </div>
                @endforeach
                
                {!! field()->checkBox('status_possibility['.$possibility->id.']', __('subscription::dashboard.subscriptions.form.status'),null,[$possibility->status ? 'checked':'' => '']) !!}
            </div>
        @endforeach
    @endif
</div>
<br>
<div id="possibility-template" style="display: none;">
    <div class="row delete-content" style="margin-top: 20px;padding: 16px 11px;box-shadow: 0px 0px 3px 0px #3641503d;">
        <span class="delete-possibility">
            <i class="fa fa-remove"></i>
        </span>

        @foreach (config('laravellocalization.supportedLocales') as $code => $lang)
            <div class="col-xs-12">
                {!! field()->text('title_possibility[::index]['.$code.']',
                __('subscription::dashboard.subscriptions.form.title').'-'.$code ,
                        null,
                      ['data-name' => 'title.::index'.$code]
                 ) !!}
            </div>
        @endforeach

        {!! field()->checkBox('status_possibility[::index]', __('subscription::dashboard.subscriptions.form.status'),null,['class' => '::switch']) !!}
    </div>
</div>
<br>
<div class="form-group">
    <button
            type="button"
            class="btn btn-sm green add-possibility"
            data-style="slide-down"
            data-spinner-color="#333">
        <i class="fa fa-plus-circle"></i>
        {{ __('subscription::dashboard.subscriptions.form.add')}}
    </button>
</div>

@push('scripts')
    <script>
        // member FORM / ADD NEW member
        $(document).ready(function () {
            var html = $('#possibility-template').html();

            $(".add-possibility").click(function (e) {
                var content = html;

                var rand = Math.floor(Math.random() * 9000000000) + 1000000000;
                content = replaceAll(content, '::index', rand);
                content = replaceAll(content, '::switch', 'switch');
                e.preventDefault();
                $(".possibilities-form").append(content);
                $(".switch").bootstrapSwitch({size: "small"});
                
            });
            $('#is_free').on('switchChange.bootstrapSwitch', function (event, state) {
                if (state == true) {
                    $('#price-content').hide();
                }else{
                    $('#price-content').show();
                }
            });
        });

        // DELETE member BUTTON
        $(".possibilities-form").on("click", ".delete-possibility", function (e) {
            e.preventDefault();
            $(this).closest('.delete-content').remove();
        });

        function escapeRegExp(string) {
            return string.replace(/[.*+?^${}()|[\]\\]/g, "\\$&");
        }

        /* Define functin to find and replace specified term with replacement string */
        function replaceAll(str, term, replacement) {
            return str.replace(new RegExp(escapeRegExp(term), 'g'), replacement);
        }

    </script>
@endpush

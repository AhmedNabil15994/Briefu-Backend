
{!! field()->langNavTabs() !!}

<div class="tab-content">
    @foreach (config('laravellocalization.supportedLocales') as $code => $lang)
        <div class="tab-pane fade in {{ ($code == locale()) ? 'active' : '' }}"
             id="first_{{$code}}">
            {!! field()->text('title['.$code.']',
            __('subscription::dashboard.bertypes.form.title').'-'.$code ,
                    $model->getTranslation('title' , $code),
                  ['data-name' => 'title.'.$code]
             ) !!}
        </div>
    @endforeach
</div>

{!! field()->number('days_number', __('subscription::dashboard.bertypes.form.days_number')) !!}
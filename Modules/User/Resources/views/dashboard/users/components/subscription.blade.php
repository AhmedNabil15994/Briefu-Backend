@php $subscription = $user->activeSubscription; @endphp

@if($subscription)
    @push('styles')
        <style>
            .delete-possibility{
                position: absolute;
                left: 20px;
                color: #ff2841;
                font-size: 19px;    
                z-index: 3;
                cursor: pointer;
            }
        </style>
    @endpush

    
    {!! field()->text('', __('subscription::dashboard.subscriptions.form.title') , $subscription->title,['disabled' => '']) !!}
    
    {!! field()->date('expired_date', __('subscription::dashboard.subscriptions.form.expired_at'),Carbon\Carbon::parse($subscription->expired_date)->toDateString()) !!}

    @php 
        $accessesIds = $subscription->possibilities()->whereNull('title')->first();
        $accessesIds = $accessesIds && $accessesIds->accesses()->count() ? $accessesIds->accesses->pluck('access_to')->toArray() : [];
    @endphp
    {!! field()->multiSelect('access_to' , __('subscription::dashboard.subscriptions.form.access_to'),Modules\Subscription\Entities\Access::accessTypeForSelect(), $accessesIds , [
    "class" => "form-control select2"
    ]) !!}

    @push('scripts')
        <script>
            // member FORM / ADD NEW member
            $(document).ready(function () {
                var html = $('#possibility-template').html();

                $(".add-possibility").click(function (e) {
                    var content = html;

                    var rand = Math.floor(Math.random() * 9000000000) + 1000000000;
                    content = replaceAll(content, '::index', rand);
                    e.preventDefault();
                    $(".possibilities-form").append(content);
                    $(".select").select2();
                    
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

@else
    <div class="alert alert-danger">{{__('user::dashboard.users.update.form.dont_has_subscription')}}</div>
@endif

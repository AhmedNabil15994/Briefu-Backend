<?php

namespace Modules\Subscription\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Apps\Http\Controllers\Api\ApiController;
use Modules\DailyMessage\Console\SendDailyMessage;
use Modules\Subscription\Http\Requests\Api\SubscriptionRequest;
use Modules\Subscription\Repositories\Api\SubscriptionRepository;
use Modules\Subscription\Transformers\Api\ClientSubscriptionDataResource;
use Modules\Subscription\Transformers\Api\SubscriptionResource;
use Modules\Transaction\Services\UPaymentService;

class SubscriptionController extends ApiController
{
    private $subscriptionRepository;
    private $payment;

    public function __construct(SubscriptionRepository $subscriptionRepository)
    {
        $this->payment = new UPaymentService();
        $this->subscriptionRepository = $subscriptionRepository;
    }

    public function index(Request $request)
    {
        return SubscriptionResource::collection($this->subscriptionRepository->getPagination($request, 'order', 'asc'));
    }

    public function mySubscription(Request $request)
    {
        $subscription = $this->subscriptionRepository->mySubscription($request);
        if($subscription)
            return $this->response(new ClientSubscriptionDataResource($subscription));
        else
            return $this->error(__('user::dashboard.users.update.form.dont_has_subscription'));
    }

    public function freeSubscriptionStatus(Request $request)
    {
        $status = 'saved';

        if ($request->user()->take_free_subscription == 1 && $request->user('api')->free_subscription_status != 'saved') {
            if ($request->user('api')->subscription->is_free == 1) {
                if ($request->user('api')->subscription->is_expired) {
                    $status = 'expired';
                    $request->user('api')->free_subscription_status = 'saved';
                    $request->user('api')->save();
                } else {
                    $status = $request->user('api')->free_subscription_status;
                }
            }
        }


        if ($request->user('api')->subscriptions()->where('is_free',1)->count()<=0) {
            $status='not_joined';
        }

        return $this->response(['status' => $status]);
    }

    public function subscribe(SubscriptionRequest $request, $id)
    {
        $subscription = $this->subscriptionRepository->subscribe($request, $id);

        if ($subscription) {
            if ($subscription[0] == 1) {
                $subscription = $subscription[1];
                $response = $subscription->is_apple_tier ? 
                new ClientSubscriptionDataResource($subscription) :
                 ['paymentUrls' =>  $this->payment->send($subscription, 'subscription')];

                return $this->response($response);
            }

            if ($subscription[0] == 2) {
                return $this->response(null);
            }
        }

        return $this->error($subscription[1], [], 400);
    }

    public function appleUpdatePayment(SubscriptionRequest $request, $id)
    {
        $model = $this->subscriptionRepository->appleUpdatePaidStatus($request,$id);

        if ($model) {
            return $this->response([],__('apps::api.messages.success'));
        }

        return $this->error(__('apps::api.messages.failed'), [], 400);
    }

    public function success(Request $request)
    {
        $model = $this->subscriptionRepository->updatePaidStatus($request);

        if ($model) {
            return Response()->json(['msg' => __('apps::api.messages.success')]);
        }

        return $this->error(__('apps::api.messages.failed'));
    }

    public function failed(Request $request)
    {
        $model = $this->subscriptionRepository->updatePaidStatus($request);
        return $this->error(__('apps::api.messages.failed'));
    }
}
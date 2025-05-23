<?php

namespace Modules\Subscription\Repositories\Api;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Core\Repositories\Api\ApiCrudRepository;
use Modules\Coupon\Http\Controllers\WebService\CouponController;
use Modules\DailyMessage\Console\SendDailyMessage;
use Modules\Subscription\Entities\ClientSubscription as Transaction;
use Modules\Subscription\Entities\Subscription;
use AmrShawky\LaravelCurrency\Facade\Currency;

class SubscriptionRepository extends ApiCrudRepository
{
    private $transactions;

    public function __construct()
    {
        parent::__construct(Subscription::class);
        $this->transactions = new Transaction;
    }

    public function mySubscription(Request $request){
        $user = $request->user('api');
        return $user->activeSubscription;
    }

    /**
     * @return mixed|null
     */
    public function getModel()
    {
        return $this->model->active();
    }

    public function findById($id){
        return $this->getModel()->find($id);
    }

    public function findTransactionById($id){
        return $this->transactions->where('paid','pending')->find($id);
    }

    public function subscribe(Request $request , $id){

        $client = $request->user('api');
        $current_subscription = $request->user('api')->subscription;

        try {
            DB::beginTransaction();

            $subscription = $this->findById($id);

            if($request->coupon_code){

                $checkCoupon = CouponController::check($request,$subscription);

                if($checkCoupon[0]){

                    $coupon = $checkCoupon['coupon'];
                    $checkCoupon = $checkCoupon['data'];
                }else{

                    return [0 , $checkCoupon[1]];
                }

            }else{

                $checkCoupon = null;
                $coupon = null;
            }

            if(!$subscription)
                return [0 , __('subscription::api.message.not_found')];

            if($subscription->is_free == 1 && $client->subscriptionsTransactions()->find($subscription->id))
                return [0 , __('subscription::api.message.you_already_tacked_this_free_subscription')];

            $client->subscriptionsTransactions()->wherePivot('paid', 'pending')->detach();

            if($current_subscription){

                if(optional($this->mySubscription($request))->is_free && optional($this->mySubscription($request))->is_free != 1)
                    return [0 , __('subscription::api.message.You_are_al_ready_subscribed')];

                //renew current subscription
                if($current_subscription->subscription_id == $subscription->id){

                    $days_number = $current_subscription->expired_date > Carbon::now() ?
                        $subscription->days_number + $current_subscription->expired_date->diffInDays(Carbon::now()) : $subscription->days_number;

                    $data = [
                        'title' => ['en' => $subscription->getTranslation('title', 'en'), 'ar' => $subscription->getTranslation('title', 'en')],
                        'subscription_id' => $subscription->id,
                        'days_number' => $days_number,
                        'expired_date' => Carbon::now()->addDays($days_number)->toDateTimeString(),
                        'amount' => !is_null($subscription->tier) ? $subscription->tier->price : $subscription->price,
                        'action_type' => 'renew',
                        'is_free' => $subscription->is_free,
                    ];

                }else{
                    //change current subscription
                    $data = [
                        'title' => ['en' => $subscription->getTranslation('title', 'en'), 'ar' => $subscription->getTranslation('title', 'en')],
                        'subscription_id' => $subscription->id,
                        'days_number' => $subscription->days_number,
                        'expired_date' => Carbon::now()->addDays($subscription->days_number)->toDateTimeString(),
                        'amount' => !is_null($subscription->tier) ? $subscription->tier->price : $subscription->price,
                        'action_type' => 'change_subscription',
                        'is_free' => $subscription->is_free,
                    ];
                }

            }else{

                //new subscribing
                $data = [
                    'title' => ['en' => $subscription->getTranslation('title', 'en'), 'ar' => $subscription->getTranslation('title', 'en')],
                    'subscription_id' => $subscription->id,
                    'days_number' => $subscription->days_number,
                    'expired_date' => Carbon::now()->addDays($subscription->days_number)->toDateTimeString(),
                    'amount' => !is_null($subscription->tier) ? $subscription->tier->price : $subscription->price,
                    'is_free' => $subscription->is_free,
                ];
            }

            // \File::append(storage_path().'/logs/data-before-'.date('Y-m-d').'.log', json_encode($data). PHP_EOL);

            if( isset($data['amount']) && !is_null($subscription->tier) ){
                // $data['amount'] = Currency::convert()->from('USD')->to('KWD')->get() * $data['amount'];
                $data['amount'] = $data['amount'] * 0.3093;
            }

            if($request->pay_with && $request->pay_with == 'apple'){

                $data['is_apple_tier'] = true;
            }

            if($checkCoupon){
                $data['amount'] = $checkCoupon['total'];
                $data['discount_value'] = $checkCoupon['discount_value'];
                $data['coupon_id'] = $coupon->id;
            }
            
            // \File::append(storage_path().'/logs/data-after-'.date('Y-m-d').'.log', json_encode($data). PHP_EOL);

            $newSubscription = $client->subscriptions()->create($data);
            
            $this->setPossibilityAndAccess($subscription, $newSubscription);

            $PendingSubscription = $client->PendingSubscription;

            if(!$PendingSubscription)
                return [0 , __('subscription::api.message.subscribe_field')];

            if($subscription->is_free == 1){
                $client->subscriptions()->where('paid','paid')->update(['paid' => 'expired']);
                $PendingSubscription->paid = 'paid';
                $PendingSubscription->expired_date = Carbon::now()->addDays($PendingSubscription->days_number)->toDateTimeString();
                $PendingSubscription->save();
            }

            DB::commit();
            return [$subscription->is_free == 1 ? 2 : 1,$PendingSubscription];

        }catch (\Exception $e){

            throw $e;
        }
    }

    public function setPossibilityAndAccess($subscription, $clientSubscription){
        
        foreach($subscription->possibilities as $possibility){


            if($possibility->title == null){

                $clientSubscriptionPossibility = $clientSubscription->possibilities()->create([

                    'client_subscription_id' => $clientSubscription->id
                ]);

                foreach($possibility->accesses as $access){

                    $clientSubscriptionPossibility->accesses()->create([
    
                        'access_to' => $access->access_to,
                    ]);
                }
                
            }else{

                $clientSubscriptionPossibility = $clientSubscription->possibilities()->create([

                    'title' => ['en' => $possibility->getTranslation('title', 'en'), 'ar' => $possibility->getTranslation('title', 'en')],
                    'status' => $possibility->status,
                ]);
            }
        }
    }

    public function updatePaidStatus($request)
    {
        $model = $this->findTransactionById($request['OrderID']);
        DB::beginTransaction();

        try {

            if ($model) {
                if ($request['Result'] == 'CAPTURED') {

                    $client = $model->client;
                    $client->subscriptions()->where('paid','paid')->update(['paid' => 'expired']);

                    $model->paid = 'paid';
                    $model->expired_date = Carbon::now()->addDays($model->days_number)->toDateTimeString();
                    $model->save();


                } else {
                    $model->delete();
                }

                DB::commit();
                return true;
            }

            return false;

        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function appleUpdatePaidStatus($request,$id)
    {
        $model = $this->findTransactionById($id);
        DB::beginTransaction();

        try {

            if ($model) {
                if ($request->status == 'success') {

                    $client = $model->client;
                    $client->subscriptions()->where('paid','paid')->update(['paid' => 'expired']);

                    $model->paid = 'paid';
                    $model->apple_transaction_data = [
                        'transaction_id' => $request->transaction_id
                    ];
                    $model->expired_date = Carbon::now()->addDays($model->days_number)->toDateTimeString();
                    $model->save();


                } else {
                    $model->delete();
                }

                DB::commit();
                return true;
            }

            return false;

        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function appendFilter(&$query, $request): \Illuminate\Database\Eloquent\Builder
    {
        // if ($request->user('api') && $request->user('api')->take_free_subscription == 1) {
        //     $query->where('is_free', 0);
        // }
        return parent::appendFilter($query, $request);
    }
}

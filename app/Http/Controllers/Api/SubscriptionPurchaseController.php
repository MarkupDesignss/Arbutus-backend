<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subscription;
use App\Models\UserSubscription;
use App\Models\Payment;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;

class SubscriptionPurchaseController extends Controller
{
    public function subscribe(Request $request)
    {
        $request->validate([
            'subscription_id'=>'required|exists:subscriptions,id',
            'plan_type'=>'required|in:monthly,yearly'
        ]);

        $user = auth()->user();
        $plan = Subscription::findOrFail($request->subscription_id);

        $amount = $request->plan_type == 'monthly'
            ? $plan->monthly_price
            : $plan->yearly_price;

        Stripe::setApiKey(config('services.stripe.secret'));

        $session = StripeSession::create([
            'payment_method_types'=>['card'],
            'line_items'=>[[  
                'price_data'=>[
                    'currency'=>'usd',
                    'unit_amount'=>$amount * 100,
                    'product_data'=>[
                        'name'=>$plan->name.' ('.$request->plan_type.')',
                    ]
                ],
                'quantity'=>1
            ]],
            'mode'=>'payment',
            'success_url'=>url('/api/payment-success?session_id={CHECKOUT_SESSION_ID}'),
            'cancel_url'=>url('/api/payment-cancel'),
            'metadata'=>[
                'user_id'=>$user->id,
                'subscription_id'=>$plan->id,
                'plan_type'=>$request->plan_type
            ]
        ]);

        return response()->json([
            'status'=>true,
            'payment_url'=>$session->url
        ]);
    }

    // SUCCESS
    public function success(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $session = \Stripe\Checkout\Session::retrieve($request->session_id);

        if($session->payment_status != 'paid'){
            return response()->json(['status'=>false,'message'=>'Payment failed']);
        }

        $userId = $session->metadata->user_id;
        $subscriptionId = $session->metadata->subscription_id;
        $planType = $session->metadata->plan_type;

        $start = now();
        $end   = $planType == 'monthly' ? now()->addDays(30) : now()->addDays(365);

        // 1️⃣ Create subscription FIRST
        $userSub = UserSubscription::create([
            'user_id' => $userId,
            'subscription_id' => $subscriptionId,
            'plan_type' => $planType,
            'start_date' => $start,
            'end_date' => $end,
            'status' => 'active'
        ]);

        // 2️⃣ Create payment with user_subscription_id
        Payment::create([
            'user_id' => $userId,
            'user_subscription_id' => $userSub->id,
            'stripe_payment_intent_id' => $session->payment_intent,
            'amount' => $session->amount_total / 100,
            'status' => 'paid'
        ]);

        return response()->json([
            'status'=>true,
            'message'=>'Subscription activated successfully'
        ]);
    }

}

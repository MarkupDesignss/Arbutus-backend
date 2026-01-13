<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subscription;

class SubscriptionController extends Controller
{
    //List all active subscriptions
    public function index()
    {
        try {
            // Only active subscriptions
            $subscriptions = Subscription::where('is_active', 1)
                ->orderBy('id', 'desc')
                ->get();

            // Decode features and add human-readable status
            $subscriptions->transform(function ($item) {
                $item->features = json_decode($item->features, true) ?? [];
                $item->status_text = $item->is_active ? 'Active' : 'Inactive';
                return $item;
            });

            return response()->json([
                'status' => true,
                'data' => $subscriptions,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    //View single subscription by id (only if active)
    public function show($id)
    {
        try {
            $subscription = Subscription::where('id', $id)
                ->where('is_active', 1)
                ->firstOrFail();

            $subscription->features = json_decode($subscription->features, true) ?? [];
            $subscription->status_text = $subscription->is_active ? 'Active' : 'Inactive';

            return response()->json([
                'status' => true,
                'data' => $subscription,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Subscription not found or inactive',
                'error' => $e->getMessage(),
            ], 404);
        }
    }
}

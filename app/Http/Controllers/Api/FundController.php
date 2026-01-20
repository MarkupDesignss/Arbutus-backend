<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Fund;

class FundController extends Controller
{
    public function index()
    {
        try {
            $funds = Fund::with([
                    'firm:id,name',
                    'assetClass:id,name',
                    'type:id,name',
                    'strategy:id,name',
                    'category:id,name',
                    'riskRating:id,name'
                ])
                ->where('status', 1)
                ->orderBy('id', 'desc')
                ->get();

            return response()->json([
                'status'  => true,
                'message' => 'Fund list fetched successfully',
                'data'    => $funds
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Something went wrong',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function filterData(Request $request)
    {
        try {
            $funds = Fund::with([
                    'firm:id,name',
                    'assetClass:id,name',
                    'type:id,name',
                    'strategy:id,name',
                    'category:id,name',
                    'riskRating:id,name',
                ])
                ->where('status', 1)

                // ID based filters
                ->when($request->firm_id, function ($q) use ($request) {
                    $q->where('firm_id', $request->firm_id);
                })
                ->when($request->asset_class_id, function ($q) use ($request) {
                    $q->where('asset_class_id', $request->asset_class_id);
                })
                ->when($request->type_id, function ($q) use ($request) {
                    $q->where('type_id', $request->type_id);
                })
                ->when($request->strategy_id, function ($q) use ($request) {
                    $q->where('strategy_id', $request->strategy_id);
                })
                ->when($request->category_id, function ($q) use ($request) {
                    $q->where('category_id', $request->category_id);
                })
                ->when($request->risk_rating_id, function ($q) use ($request) {
                    $q->where('risk_rating_id', $request->risk_rating_id);
                })

                ->orderBy('id', 'desc')
                ->get();

            return response()->json([
                'status'  => true,
                'message' => 'Fund list fetched successfully',
                'data'    => $funds
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Something went wrong',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
}

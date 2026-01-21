<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AssetClass;

class AssetClassController extends Controller
{   
    public function index()
    {
        try {
            $classes = AssetClass::where('status', 1)
                ->orderBy('id', 'desc')
                ->get();

            return response()->json([
                'status'  => true,
                'message' => 'Asset class list fetched successfully',
                'data'    => $classes
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

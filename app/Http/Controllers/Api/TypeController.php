<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Type;

class TypeController extends Controller
{
    public function index()
    {
        try {
            $type = Type::where('status', 1)
                ->orderBy('id', 'desc')
                ->get();

            return response()->json([
                'status'  => true,
                'message' => 'Type list fetched successfully',
                'data'    => $type
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

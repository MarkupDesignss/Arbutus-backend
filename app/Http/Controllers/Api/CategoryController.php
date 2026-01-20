<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        try {
            $category = Category::where('status', 1)
                ->orderBy('id', 'desc')
                ->get();

            return response()->json([
                'status'  => true,
                'message' => 'Category list fetched successfully',
                'data'    => $category
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

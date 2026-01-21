<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OurValue;
use Exception;

class OurValueController extends Controller
{
    // All Values List
    public function list()
    {
        try {
            $values = OurValue::where('status', 1)->get(['id','title','short_description','long_description','image']);

            // Map image to full URL
            $values->transform(function($values){
                $values->image = $values->image ? asset('storage/values/'.$values->image) : null;
                return $values;
            });

            return response()->json([
                'status' => true,
                'message' => 'Our Value list fetched successfully',
                'data' => $values
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to fetch Our value list',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Single Values Details by id
    public function details($id)
    {
        try {
            $value = OurValue::where('id', $id)
                        ->where('status', 1)
                        ->first();

            if (!$value) {
                return response()->json([
                    'status' => false,
                    'message' => 'Our value not found'
                ], 404);
            }

            return response()->json([
                'status' => true,
                'message' => 'Our value details fetched',
                'data' => [
                    'id' => $value->id,
                    'title' => $value->title,
                    'image' => $value->image ? asset('storage/values/'.$value->image) : null,
                    'short_description' => $value->short_description,
                    'long_description' => $value->long_description
                ]
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to fetch Our value details',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
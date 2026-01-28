<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sponsors;
use Illuminate\Support\Facades\URL;

class SponsorsController extends Controller
{
    
    public function index()
    {
        try {
            $sponsors = Sponsors::where('status', 1)
                ->orderBy('id', 'desc')
                ->get()
                ->map(function ($item) {
                    return [
                        'id'    => $item->id,
                        'image' => URL::to('storage/sponsors/' . $item->image),
                        'status'=> $item->status,
                    ];
                });

            return response()->json([
                'success' => true,
                'message' => 'Sponsors fetched successfully',
                'data'    => $sponsors
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
}

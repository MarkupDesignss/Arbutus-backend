<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Exception;

class BannerController extends Controller
{
    public function index()
    {
        try {
            $banners = Banner::select('id','title','image','status','description')
                ->where('status',1)
                ->latest()
                ->get()
                ->map(function ($banner) {

                    $banner->image = $banner->image
                        ? asset('storage/banners/'.$banner->image)
                        : null;

                    return $banner;
                });

            if ($banners->isEmpty()) {
                return response()->json([
                    'status'  => false,
                    'message' => 'No banner found',
                    'data'    => [],
                ],200);
            }

            return response()->json([
                'status'  => true,
                'message' => 'Banners retrieved successfully',
                'data'    => $banners,
            ],200);

        } catch (Exception $e) {

            return response()->json([
                'status'  => false,
                'message' => 'Something went wrong',
                'error'   => $e->getMessage(),
            ],500);
        }
    }
}

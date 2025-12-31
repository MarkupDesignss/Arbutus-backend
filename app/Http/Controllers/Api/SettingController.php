<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use Exception;

class SettingController extends Controller
{
    // GET ALL SETTINGS
    public function index()
    {
        try {
            $settings = Setting::pluck('value','key');

            return response()->json([
                'status' => true,
                'data'   => $settings
            ]);
        } catch(Exception $e){
            return response()->json([
                'status' => false,
                'message'=> 'Failed to fetch settings',
                'error'  => $e->getMessage()
            ],500);
        }
    }

}

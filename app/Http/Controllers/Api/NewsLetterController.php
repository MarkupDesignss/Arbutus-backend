<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NewsLetter;
use Exception;

class NewsLetterController extends Controller
{
    public function subscribe(Request $request)
    {
        try {
            //Validation
            $request->validate([
                'email' => 'required|email|max:255',
            ]);

            //Store Data
            NewsLetter::create([
                'email' => $request->email,
            ]);

            return response()->json([
                'status'  => true,
                'message' => 'Subscribed to newsletter successfully',
            ], 200);

        } catch (\Illuminate\Validation\ValidationException $e) {

            return response()->json([
                'status'  => false,
                'message' => 'Validation failed',
                'errors'  => $e->errors(),
            ], 422);

        } catch (Exception $e) {

            return response()->json([
                'status'  => false,
                'message' => 'Something went wrong',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }
}

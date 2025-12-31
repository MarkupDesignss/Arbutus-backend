<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Exception;

class AuthController extends Controller
{
    // SEND OTP
    public function sendOtp(Request $request)
    {
        try {

            $request->validate(['email'=>'required|email']);

            $otp = rand(1000,9999);

            User::updateOrCreate(
                ['email'=>$request->email],
                [
                    'otp'=>$otp,
                    'otp_expires_at'=>Carbon::now()->addMinutes(5),
                    'status'=>1
                ]
            );

            Mail::raw("Your Arbutus login OTP is: $otp", function($message) use ($request){
                $message->to($request->email)
                        ->subject('Your Login OTP');
            });

            return response()->json([
                'status'=>true,
                'message'=>'OTP sent to your email'
            ]);

        } catch (Exception $e) {

            return response()->json([
                'status'=>false,
                'message'=>'Something went wrong',
                'error'=>$e->getMessage()
            ],500);
        }
    }

    // VERIFY OTP & GENERATE TOKEN
    public function verifyOtp(Request $request)
    {
        try {

            $request->validate([
                'email'=>'required|email',
                'otp'=>'required|digits:4'
            ]);

            $user = User::where('email',$request->email)->first();

            if(!$user){
                return response()->json(['status'=>false,'message'=>'User not found'],404);
            }

            if($user->otp != $request->otp){
                return response()->json(['status'=>false,'message'=>'Invalid OTP'],401);
            }

            if(Carbon::now()->gt($user->otp_expires_at)){
                return response()->json(['status'=>false,'message'=>'OTP expired'],401);
            }

            // Generate API Token
            $token = Str::random(60);

            $user->update([
                'api_token'=>$token,
                'otp'=>null,
                'otp_expires_at'=>null
            ]);

            return response()->json([
                'status'=>true,
                'message'=>'Login successful',
                'token'=>$token,
                'user'=>$user
            ]);

        } catch (Exception $e) {

            return response()->json([
                'status'=>false,
                'message'=>'Something went wrong',
                'error'=>$e->getMessage()
            ],500);
        }
    }
}

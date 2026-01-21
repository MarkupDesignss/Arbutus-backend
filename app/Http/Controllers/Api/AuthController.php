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
    //SEND OTP
    public function sendOtp(Request $request)
    {
        try {
            $request->validate([
                "email" => "required|email",
            ]);

            $otp = rand(1000, 9999);

            $user = User::updateOrCreate(
                ["email" => $request->email],
                [
                    "otp" => $otp,
                    "otp_expires_at" => now()->addMinutes(5),
                    "status" => 1,
                ]
            );

            Mail::raw("Your OTP for login is: {$otp}", function ($message) use (
                $request
            ) {
                $message->to($request->email)->subject("Login OTP");
            });

            return response()->json([
                "status" => true,
                "message" => "OTP sent successfully",
            ]);
        } catch (\Exception $e) {
            return response()->json(
                [
                    "status" => false,
                    "message" => "Unable to send OTP",
                    "error" => $e->getMessage(),
                ],
                500
            );
        }
    }

    //VERIFY OTP & GENERATE TOKEN
    public function verifyOtp(Request $request)
    {
        try {
            $request->validate([
                "email" => "required|email",
                "otp" => "required|digits:4",
            ]);

            $user = User::where("email", $request->email)->first();

            if (!$user) {
                return response()->json(
                    ["status" => false, "message" => "User not found"],
                    404
                );
            }

            if ($user->otp != $request->otp) {
                return response()->json(
                    ["status" => false, "message" => "Invalid OTP"],
                    401
                );
            }

            if (now()->gt($user->otp_expires_at)) {
                return response()->json(
                    ["status" => false, "message" => "OTP expired"],
                    401
                );
            }

            $user->update([
                "otp" => null,
                "otp_expires_at" => null,
                "email_verified_at" => now(),
            ]);

            $token = $user->createToken("auth_token")->plainTextToken;

            return response()->json([
                "status" => true,
                "message" => "Login successful",
                "access_token" => $token,
                "token_type" => "Bearer",
                "data" => $user,
            ]);
        } catch (\Exception $e) {
            return response()->json(
                [
                    "status" => false,
                    "message" => "Login failed",
                    "error" => $e->getMessage(),
                ],
                500
            );
        }
    }

    //GET USER PROFILE
    public function profile(Request $request)
    {
        try {
            $user = auth()->user();

            if(!$user){
                return response()->json([
                    'status'=>false,
                    'message'=>'User not found'
                ],404);
            }

            return response()->json([
                'status'=>true,
                'message'=>'User profile fetched successfully',
                'data'=>$user
            ]);
        } catch(Exception $e){
            return response()->json([
                'status'=>false,
                'message'=>'Failed to fetch profile',
                'error'=>$e->getMessage()
            ],500);
        }
    }

    //UPDATE USER PROFILE
    public function updateProfile(Request $request)
    {
        try {
            $user = auth()->user();

            if(!$user){
                return response()->json([
                    'status'=>false,
                    'message'=>'User not found'
                ],404);
            }

            $request->validate([
                'name'  => 'nullable|string|max:255',
                'email' => 'nullable|email|unique:users,email,'.$user->id,
                'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            ]);

            $data = $request->only(['name','email']);

            // Image Upload
            if($request->hasFile('image')){
                $image = $request->file('image');
                $fileName = 'user_'.$user->id.'_'.time().'.'.$image->getClientOriginalExtension();
                $destination = public_path('uploads/users');

                if(!file_exists($destination)){
                    mkdir($destination,0755,true);
                }

                // Delete old image
                if($user->image && file_exists(public_path(parse_url($user->image,PHP_URL_PATH)))){
                    unlink(public_path(parse_url($user->image,PHP_URL_PATH)));
                }

                $image->move($destination,$fileName);
                $data['image'] = url('uploads/users/'.$fileName);
            }

            $user->update($data);

            return response()->json([
                'status'=>true,
                'message'=>'Profile updated successfully',
                'data'=>$user
            ]);

        } catch(Exception $e){
            return response()->json([
                'status'=>false,
                'message'=>'Failed to update profile',
                'error'=>$e->getMessage()
            ],500);
        }
    }

    //LOGOUT USER
    public function logout(Request $request)
    {
        try {
            $user = auth()->user();

            if(!$user){
                return response()->json([
                    'status'=>false,
                    'message'=>'User not found'
                ],404);
            }

            // Delete current token
            $request->user()->currentAccessToken()->delete();

            return response()->json([
                'status'=>true,
                'message'=>'Logged out successfully'
            ]);
        } catch(Exception $e){
            return response()->json([
                'status'=>false,
                'message'=>'Logout failed',
                'error'=>$e->getMessage()
            ],500);
        }
    }

    //DELETE USER ACCOUNT
    public function deleteAccount(Request $request)
    {
        try {
            $user = auth()->user();

            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'User not found or not authenticated.'
                ], 404);
            }

            // Directly delete user
            $user->delete();

            return response()->json([
                'status' => true,
                'message' => 'Account deleted successfully.'
            ]);

        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to delete account.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

}

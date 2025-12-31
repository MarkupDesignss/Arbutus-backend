<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;
use Exception;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        try {
            //Validation
            $request->validate([
                'fname'   => 'required|string|max:255',
                'lname'   => 'required|string|max:255',
                'topic'   => 'required|string|max:255',
                'mobile'  => 'required|string|max:15',
                'subject' => 'required|string|max:255',
                'email'   => 'required|email|max:255',
                'message' => 'required|string',
            ]);

            //Store Data
            Contact::create([
                'fname'   => $request->fname,
                'lname'   => $request->lname,
                'topic'   => $request->topic,
                'mobile'  => $request->mobile,
                'subject' => $request->subject,
                'email'   => $request->email,
                'message' => $request->message,
            ]);

            return response()->json([
                'status'  => true,
                'message' => 'Contact form submitted successfully',
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
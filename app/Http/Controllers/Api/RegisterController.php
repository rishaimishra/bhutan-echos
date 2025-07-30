<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Service\FirebaseService;
use Illuminate\Validation\Rule;

class RegisterController extends Controller
{
    public function register(Request $request, FirebaseService $firebase)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->whereNull('deleted_at'),
            ],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'phone' => ['nullable', 'string', 'max:20'],
            'device_token' => ['nullable', 'string'],
]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => 'user',
            'device_token'=>@$request->device_token,
        ]);

        // If Sanctum is installed, generate a token
        if (method_exists($user, 'createToken')) {
            $token = $user->createToken('api_token')->plainTextToken;
        } else {
            $token = null;
        }


          // Send FCM push notification
          // $allTokens = User::whereNotNull('device_token')->pluck('device_token')->toArray();

          //   if (!empty($allTokens)) {
          //       foreach (array_chunk($allTokens, 500) as $deviceTokens) {
          //           $title = 'New User Registered!';
          //           $body = 'Say hello to ' . $user->name . '';
          //           $firebase->sendNotification($deviceTokens, $title, $body);
          //       }
          //   }

        return response()->json([
            'message' => 'User registered successfully.',
            'user' => $user,
            'token' => $token,
        ], 201);
    }

    public function sendSignupMail(Request $request)
    {
        // Validate incoming request
        $validatedData = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'verification_link' => 'required|url',
        ]);

        try {
            \Log::info('sendSignupMail called', $validatedData);
            
            // Call the sendSignupMailToCustomer function
            $name = $validatedData['name'];
            $email = $validatedData['email'];
            $verificationLink = $validatedData['verification_link'];

            $result = $this->sendSignupMailToCustomer($name, $email, $verificationLink);
            
            \Log::info('sendSignupMailToCustomer result', ['result' => $result]);

            if ($result) {
                \Log::info('Returning success response');
                return response()->json([
                    'status' => 200,
                    'message' => 'Signup email sent successfully.',
                ], 200);
            } else {
                \Log::error('Email sending failed');
                return response()->json([
                    'status' => 500,
                    'message' => 'Failed to send signup email. Check logs for details.',
                ], 500);
            }
        } catch (\Exception $e) {
            \Log::error('sendSignupMail exception', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'status' => 500,
                'message' => 'An error occurred while sending the signup email.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function sendSignupMailToCustomer($name, $email, $verificationLink)
    {
        try {
            // Load email template
            $body_message = view('mail.verify', compact('name', 'email', 'verificationLink'))->render();
            
            \Log::info('Email template loaded successfully', ['email' => $email, 'name' => $name]);

            // Use Laravel's Mail facade with better configuration
            Mail::html($body_message, function ($message) use ($email, $name) {
                $message->from('backupjeet962@gmail.com', 'Bhutan Echos')
                    ->to($email, $name)
                    ->subject('Bhutan Echos - Customer Registration')
                    ->replyTo('backupjeet962@gmail.com', 'Bhutan Echos Support')
                    ->priority(1); // High priority
            });
            
            \Log::info('Email sent successfully', ['email' => $email]);
            return true; // Email sent successfully
        } catch (\Exception $e) {
            // Log any exception that occurs during the process
            \Log::error('SendSignupMailToCustomer Exception: ' . $e->getMessage(), [
                'email' => $email,
                'name' => $name,
                'trace' => $e->getTraceAsString()
            ]);
            return false;
        }
    }

    public function emailVerify($id)
    {

        $user = User::where('id', $id)->first();
        if (@$user == "") {
            return 'User not found';
        }
        User::where('id', $id)->update(['is_verified' => '1']);
        return view('verify_email');
    }
}
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class PasswordResetController extends Controller
{
    public function forgotPassword(Request $request)
    {
        // Validate the request
        $request->validate([
            'email' => 'required|email',
        ]);

        try {
            // Check if user exists
            $user = User::where('email', $request->email)->first();
            
            if (!$user) {
                return response()->json([
                    'status' => 404,
                    'message' => 'User with this email address not found.',
                ], 404);
            }

            // Generate reset token
            $resetToken = Str::random(60);
            
            // Store reset token in user record
            $user->update([
                'password_reset_token' => $resetToken,
                'password_reset_expires_at' => now()->addHours(24), // Token expires in 24 hours
            ]);

            // Generate reset link
            $resetLink =  url('reset-password/' . $resetToken);

            // Send reset email
            $this->sendPasswordResetEmail($user->name, $user->email, $resetLink);

            return response()->json([
                'status' => 200,
                'message' => 'Password reset email sent successfully.',
            ], 200);

        } catch (\Exception $e) {
            \Log::error('ForgotPassword Exception: ' . $e->getMessage(), [
                'email' => $request->email,
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'status' => 500,
                'message' => 'An error occurred while processing your request.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function resetPassword(Request $request, $token)
    {
        // Validate the request
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        // dd($request->all());


        try {
            // Find user by reset token
            $user = User::where('email', $request->email)
                    //    ->where('password_reset_expires_at', '>', now())
                       ->first();

            if (!$user) {
                return response()->json([
                    'status' => 400,
                    'message' => 'Invalid or expired reset token.',
                ], 400);
            }

            // Update password and clear reset token
            $user->update([
                'password' => Hash::make($request->password),
                'password_reset_token' => null,
                'password_reset_expires_at' => null,
            ]);

            return response()->json([
                'status' => 200,
                'message' => 'Password updated successfully.',
            ], 200);

        } catch (\Exception $e) {
            \Log::error('ResetPassword Exception: ' . $e->getMessage(), [
                'token' => $token,
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'status' => 500,
                'message' => 'An error occurred while resetting your password.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function verifyResetToken($token)
    {
        try {
            // Find user by reset token
            $user = User::where('password_reset_token', $token)
                       ->where('password_reset_expires_at', '>', now())
                       ->first();

            if (!$user) {
                return response()->json([
                    'status' => 400,
                    'message' => 'Invalid or expired reset token.',
                ], 400);
            }

            return response()->json([
                'status' => 200,
                'message' => 'Valid reset token.',
                'email' => $user->email,
            ], 200);

        } catch (\Exception $e) {
            \Log::error('VerifyResetToken Exception: ' . $e->getMessage(), [
                'token' => $token,
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'status' => 500,
                'message' => 'An error occurred while verifying the reset token.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    private function sendPasswordResetEmail($name, $email, $resetLink)
    {
        try {
            // Load email template
            $body_message = view('mail.password-reset', compact('name', 'email', 'resetLink'))->render();
            
            \Log::info('Password reset email template loaded', ['email' => $email]);

            // Send email
            Mail::html($body_message, function ($message) use ($email, $name) {
                $message->from('backupjeet962@gmail.com', 'Bhutan Echos')
                    ->to($email, $name)
                    ->subject('Bhutan Echos - Password Reset Request')
                    ->replyTo('backupjeet962@gmail.com', 'Bhutan Echos Support')
                    ->priority(1);
            });
            
            \Log::info('Password reset email sent successfully', ['email' => $email]);
            return true;

        } catch (\Exception $e) {
            \Log::error('SendPasswordResetEmail Exception: ' . $e->getMessage(), [
                'email' => $email,
                'name' => $name,
                'trace' => $e->getTraceAsString()
            ]);
            return false;
        }
    }
} 
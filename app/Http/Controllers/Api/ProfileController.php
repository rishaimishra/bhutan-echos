<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ProfileController extends Controller
{
    public function profile(Request $request)
    {
        $user = $request->user();
        if (!$user) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }
        return response()->json([
            'user' => $user,
            'user_image' => $user->user_image ? url($user->user_image) : null,
        ]);
    }

    // public function updateProfile(Request $request)
    // {
    //     $user = $request->user();
    //     if (!$user) {
    //         return response()->json(['message' => 'Unauthenticated.'], 401);
    //     }

    //     $validated = $request->validate([
    //         'name' => 'required|string|max:255',
    //         'email' => 'required|email|max:255|unique:users,email,' . $user->id,
    //         'password' => 'nullable|string|min:6',
    //         'user_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    //     ]);

    //     if (isset($validated['password'])) {
    //         $validated['password'] = bcrypt($validated['password']);
    //     } else {
    //         unset($validated['password']);
    //     }

    //     if ($request->hasFile('user_image')) {
    //         $image = $request->file('user_image');
    //         $imageName = 'profile_images/' . uniqid() . '.' . $image->getClientOriginalExtension();
    //         $image->move(public_path('profile_images'), $imageName);
    //         $validated['user_image'] = $imageName;
    //     }

    //     $user->update($validated);

    //     return response()->json([
    //         'message' => 'Profile updated successfully.',
    //         'user' => $user,
    //         'user_image' => $user->user_image ? url($user->user_image) : null,
    //     ]);
    // }

public function updateProfile(Request $request)
{
    try {
        $user = $request->user();

        if (!$user) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|max:255|unique:users,email,' . $user->id,
            'password' => 'sometimes|nullable|string|min:6',
           'user_image' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:10240',

        ]);

        if (isset($validated['password']) && $validated['password']) {
            $validated['password'] = bcrypt($validated['password']);
        } else {
            unset($validated['password']);
        }

        if ($request->hasFile('user_image')) {
            $image = $request->file('user_image');
            $imageName = 'profile_images/' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('profile_images'), $imageName);
            $validated['user_image'] = $imageName;
        }

        $user->update($validated);

        return response()->json([
            'message' => 'Profile updated successfully.',
            'user' => $user,
            'user_image' => $user->user_image ? url($user->user_image) : null,
        ]);
    } catch (\Exception $e) {
            \Log::error('profile error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request' => $request->all(),
            ]);
            return response()->json([
                'message' => 'An error occurred while creating the profile entry.',
                'error' => $e->getMessage(),
            ], 500);
        }
}


    public function profileInfoUpdate(Request $request)
    {
        $user = $request->user();
        if (!$user) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'sometimes|nullable|string|min:6',
            'user_image' => 'sometimes|nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if (isset($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        } else {
            unset($validated['password']);
        }

        if ($request->hasFile('user_image')) {
            $image = $request->file('user_image');
            $imageName = 'profile_images/' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('profile_images'), $imageName);
            $validated['user_image'] = $imageName;
        }

        $user->update($validated);

        return response()->json([
            'message' => 'Profile info updated successfully.',
            'user' => $user,
            'user_image' => $user->user_image ? url($user->user_image) : null,
        ]);
    }

    public function deleteAccount(Request $request)
    {
        $user = $request->user();
        $request->validate([
            'password' => 'required|string',
        ]);
        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Incorrect password.'
            ], 403);
        }
        $user->delete();
        return response()->json([
            'message' => 'Your account has been deleted successfully.'
        ]);
    }


    public function update_agree(Request $request){
      $user = $request->user();
        $request->validate([
            'user_agree' => 'required', //Y OR N
        ]);

        $UpdateUserAgreeStatus=User::where('id',$user->id)->update(['user_agree'=>$request->user_agree]);

        return response()->json([
            'message' => "Status Updated Successfully to {$request->user_agree}"
        ]);

    }



} 
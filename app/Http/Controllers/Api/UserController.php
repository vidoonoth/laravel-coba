<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ProfileUpdateRequest;

class UserController extends Controller
{
public function index(Request $request)
{
    $user = Auth::user();

    if (!$user) {
        if ($request->expectsJson()) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }
        return redirect()->route('login');
    }

    if ($request->expectsJson()) {
        return response()->json([
            'id' => $user->id,
            'username' => $user->username,
            'name' => $user->name,
            'email' => $user->email,
            'nik' => $user->nik,
            'numberphone' => $user->numberphone,
            'gender' => $user->gender,
            'created_at' => \Carbon\Carbon::parse($user->created_at)->locale('id')->translatedFormat('d F Y'),
            'profileImage' => $user->profileImage ? url('storage/profile_images/' . $user->profileImage) : null,
            'profile_image_url' => $user->profileImage ? asset('storage/profile_images/'.$user->profileImage) : null,
        ]);
    }

    $passwordLength = strlen($user->password);
    $passwordStars = str_repeat('*', 3);
    return view('profile.profile', compact('user', 'passwordStars'));
}
public function update(ProfileUpdateRequest $request)
{
    try {
        $user = $request->user();
        $validatedData = $request->validated();
        Log::info('Validated data', $validatedData);

        // Handle profile image update or removal
        if ($request->has('removeProfileImage') && $request->removeProfileImage) {
            // Jika permintaan untuk menghapus gambar
            if ($user->profileImage) {
                Storage::disk('public')->delete('profile_images/'.$user->profileImage);
                $validatedData['profileImage'] = null;
            }
        } elseif ($request->hasFile('profileImage')) {
            // Jika ada file gambar baru diupload
            Log::info('ProfileImage received', ['name' => $request->file('profileImage')->getClientOriginalName()]);
            $request->validate([
                'profileImage' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);
            
            // Hapus gambar lama jika ada
            if ($user->profileImage) {
                Storage::disk('public')->delete('profile_images/'.$user->profileImage);
            }
            
            // Simpan gambar baru
            $image = $request->file('profileImage');
            $imageName = time().'_'.$image->getClientOriginalName();
            $image->storeAs('profile_images', $imageName, 'public');
            $validatedData['profileImage'] = $imageName;
        }

        if ($request->filled('password')) {
            $validatedData['password'] = Hash::make($request->password);
        } else {
            unset($validatedData['password']);
        }
        Log::info('Validated data', $validatedData);
        $user->update($validatedData);
        Log::info('User after update', ['profileImage' => $user->profileImage]);

        return response()->json([
            'success' => true,
            'message' => 'Profile updated successfully',
            'data' => [
                'user' => $user->only(['id', 'username', 'name', 'email', 'gender', 'profileImage']),
                'profile_image_url' => $user->profileImage 
                    ? asset('storage/profile_images/'.$user->profileImage)
                    : null,
            ]
        ], 200);

    } catch (\Exception $e) {        
        return response()->json([
            'success' => false,
            'message' => 'Failed to update profile',
            'error' => $e->getMessage()
        ], 500);
    }
}

/**
 * Delete the user's account.
 */
public function destroy(Request $request): RedirectResponse
{
    $request->validateWithBag('userDeletion', [
        'password' => ['required', 'current_password'],
    ]);

    $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

   
}

<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index(): View
    {
        return view('profile.index');
    }

    public function settings(): View
    {
        return view('profile.settings');
    }

    public function photoUpload(Request $request): RedirectResponse
    {
        $request->validate([
            'profile_picture_path' => ['required', 'image', 'max:1000'],
        ]);

        $user = $request->user();

        // Delete the user's previous profile picture if exists
        if ($user->profile_picture_path) {
            Storage::disk('public')->delete($user->profile_picture_path);
        }

        // Create the profile picture file path in 'avatars' folder in storage
        $path = $request->file('profile_picture_path')->store('avatars', 'public');

        // Update the user's 'profile_picture_path' column
        $user->update([
            'profile_picture_path' => $path,
        ]);

        // Redirect the user back to 'profile.settings' route
        flash()->success('Profile picture uploaded successfully.');

        return redirect()->route('profile.settings');
    }

    public function deletePhoto(Request $request): RedirectResponse
    {
        $user = $request->user();

        // Delete the user's previous profile picture if exists
        if ($user->profile_picture_path) {
            Storage::disk('public')->delete($user->profile_picture_path);
        }

        // Update the user's 'profile_picture_path' column
        $user->update([
            'profile_picture_path' => null,
        ]);

        // Redirect the user back to 'profile.settings' route
        flash()->success('Profile picture deleted successfully.');

        return redirect()->route('profile.settings');
    }
}

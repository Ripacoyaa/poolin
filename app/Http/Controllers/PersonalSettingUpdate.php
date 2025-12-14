<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class  PersonalSettingUpdate extends Controller
{

public function update(Request $request)
{
    $user = auth()->user();

    $request->validate([
        'name' => ['required','string','max:255'],
        'username' => ['nullable','string','max:255'],
        'email' => ['required','email','max:255'],

        'photo' => ['nullable','image','mimes:jpg,jpeg,png,webp','max:2048'],
        'remove_photo' => ['nullable','in:0,1'],
        'password' => ['nullable','min:6','confirmed'],
    ]);

    // update text fields
    $user->name = $request->name;
    $user->username = $request->username;
    $user->email = $request->email;

    // remove photo
    if ($request->remove_photo == '1') {
        if ($user->photo_path) {
            Storage::disk('public')->delete($user->photo_path);
        }
        $user->photo_path = null;
    }

    // upload photo
    if ($request->hasFile('photo')) {
        // hapus foto lama
        if ($user->photo_path) {
            Storage::disk('public')->delete($user->photo_path);
        }

        // ✅ PENTING: simpan ke disk 'public'
        $path = $request->file('photo')->store('profile_photos', 'public');

        // ✅ simpan path tanpa "public/"
        $user->photo_path = $path;
    }

    // password optional
    if ($request->filled('password')) {
        $user->password = bcrypt($request->password);
    }

    $user->save();

    return back()->with('success', 'Update Information Success!');
}
}
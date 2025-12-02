<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();

        // detect whether the stored photo actually exists on disk (useful when public/storage symlink is missing)
        $photoExists = false;
        if ($user->photo) {
            $photoExists = Storage::disk('public')->exists($user->photo);
        }

        return view('profile.show', compact('user', 'photoExists'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $data = $request->validate([
            'name' => 'required|string|max:255',
            // allow up to 50MB (max is in kilobytes)
            'photo' => 'nullable|image|max:51200'
        ]);

        if ($request->hasFile('photo')) {
            try {
                $path = $request->file('photo')->store('profiles','public');

                // delete previous photo if exists
                if ($user->photo && Storage::disk('public')->exists($user->photo)) {
                    Storage::disk('public')->delete($user->photo);
                }

                $user->photo = $path;
            } catch (\Exception $e) {
                return back()->withErrors(['photo' => 'Gagal mengunggah foto: '.$e->getMessage()]);
            }
        }

        $user->name = $data['name'];
        $user->save();

        return back()->with('success','Profil diperbarui');
    }
}

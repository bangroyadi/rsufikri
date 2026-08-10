<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HospitalProfile;
use Illuminate\Http\Request;

class AdminProfileController extends Controller
{
    public function index()
    {
        $profile = HospitalProfile::first();
        return view('admin.profile.index', compact('profile'));
    }

    public function update(Request $request)
    {
        $profile = HospitalProfile::first();
        if (!$profile) {
            $profile = new HospitalProfile();
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:50',
            'emergency_phone' => 'nullable|string|max:50',
            'whatsapp' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
            'operating_hours' => 'nullable|string|max:255',
        ]);

        $profile->fill($validated);
        $profile->save();

        return back()->with('success', 'Profil Rumah Sakit berhasil diperbarui!');
    }
}

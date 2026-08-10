<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HospitalProfile;
use Illuminate\Http\Request;

class AdminContactController extends Controller
{
    public function index()
    {
        $profile = HospitalProfile::first();
        return view('admin.contact.index', compact('profile'));
    }

    public function update(Request $request)
    {
        $profile = HospitalProfile::first();
        if (!$profile) {
            $profile = new HospitalProfile();
        }

        $validated = $request->validate([
            'phone' => 'nullable|string|max:50',
            'emergency_phone' => 'nullable|string|max:50',
            'whatsapp' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
            'maps_embed' => 'nullable|string',
        ]);

        $profile->fill($validated);
        $profile->save();

        return back()->with('success', 'Informasi Kontak berhasil diperbarui!');
    }
}

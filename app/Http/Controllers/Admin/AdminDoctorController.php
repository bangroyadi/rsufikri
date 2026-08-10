<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\Polyclinic;
use Illuminate\Http\Request;

class AdminDoctorController extends Controller
{
    public function index()
    {
        $doctors = Doctor::with('polyclinic')->orderBy('name', 'asc')->get();
        $polyclinics = Polyclinic::where('is_active', true)->get();
        return view('admin.doctors.index', compact('doctors', 'polyclinics'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'title_degree' => 'nullable|string|max:255',
            'polyclinic_id' => 'required|exists:polyclinics,id',
            'specialty_id' => 'required|string|max:255',
            'photo' => 'nullable|string|max:500',
            'is_active' => 'boolean',
        ]);

        Doctor::create([
            'name' => $validated['name'],
            'title_degree' => $validated['title_degree'],
            'polyclinic_id' => $validated['polyclinic_id'],
            'specialty' => ['id' => $validated['specialty_id'], 'en' => $validated['specialty_id']],
            'photo' => $validated['photo'] ?? null,
            'is_active' => $request->has('is_active'),
        ]);

        return back()->with('success', 'Dokter baru berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $doctor = Doctor::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'title_degree' => 'nullable|string|max:255',
            'polyclinic_id' => 'required|exists:polyclinics,id',
            'specialty_id' => 'required|string|max:255',
            'photo' => 'nullable|string|max:500',
        ]);

        $doctor->update([
            'name' => $validated['name'],
            'title_degree' => $validated['title_degree'],
            'polyclinic_id' => $validated['polyclinic_id'],
            'specialty' => ['id' => $validated['specialty_id'], 'en' => $validated['specialty_id']],
            'photo' => $validated['photo'] ?? null,
        ]);

        return back()->with('success', 'Data dokter berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $doctor = Doctor::findOrFail($id);
        $doctor->delete();
        return back()->with('success', 'Data dokter berhasil dihapus!');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\DoctorSchedule;
use App\Models\Polyclinic;
use Illuminate\Http\Request;

class AdminDoctorController extends Controller
{
    public function index()
    {
        $doctors = Doctor::with(['polyclinic', 'schedules'])->orderBy('name', 'asc')->get();
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
            'photo_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
        ]);

        $photoUrl = $validated['photo'] ?? null;
        if ($request->hasFile('photo_file')) {
            $path = $request->file('photo_file')->store('doctors', 'public');
            $photoUrl = asset('storage/' . $path);
        }

        Doctor::create([
            'name' => $validated['name'],
            'title_degree' => $validated['title_degree'],
            'polyclinic_id' => $validated['polyclinic_id'],
            'specialty' => ['id' => $validated['specialty_id'], 'en' => $validated['specialty_id']],
            'photo' => $photoUrl,
            'is_active' => true,
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
            'photo_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
        ]);

        $photoUrl = $doctor->photo;
        if ($request->hasFile('photo_file')) {
            $path = $request->file('photo_file')->store('doctors', 'public');
            $photoUrl = asset('storage/' . $path);
        } elseif ($request->filled('photo')) {
            $photoUrl = $validated['photo'];
        }

        $doctor->update([
            'name' => $validated['name'],
            'title_degree' => $validated['title_degree'],
            'polyclinic_id' => $validated['polyclinic_id'],
            'specialty' => ['id' => $validated['specialty_id'], 'en' => $validated['specialty_id']],
            'photo' => $photoUrl,
            'is_active' => true,
        ]);

        // Auto-sync polyclinic for all associated schedules
        DoctorSchedule::where('doctor_id', $doctor->id)->update([
            'polyclinic_id' => $validated['polyclinic_id']
        ]);

        return back()->with('success', 'Data dokter & foto berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $doctor = Doctor::findOrFail($id);
        DoctorSchedule::where('doctor_id', $doctor->id)->delete();
        $doctor->delete();
        return back()->with('success', 'Data dokter beserta jadwalnya berhasil dihapus!');
    }
}

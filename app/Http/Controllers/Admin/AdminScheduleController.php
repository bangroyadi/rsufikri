<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DoctorSchedule;
use App\Models\Doctor;
use App\Models\Polyclinic;
use Illuminate\Http\Request;

class AdminScheduleController extends Controller
{
    public function index()
    {
        $schedules = DoctorSchedule::with(['doctor', 'polyclinic'])->get();
        $doctors = Doctor::where('is_active', true)->get();
        $polyclinics = Polyclinic::where('is_active', true)->get();
        return view('admin.schedules.index', compact('schedules', 'doctors', 'polyclinics'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'polyclinic_id' => 'required|exists:polyclinics,id',
            'day' => 'required|string|max:50',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);

        DoctorSchedule::create([
            'doctor_id' => $validated['doctor_id'],
            'polyclinic_id' => $validated['polyclinic_id'],
            'day' => $validated['day'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'status' => 'active',
        ]);

        return back()->with('success', 'Jadwal praktik berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $schedule = DoctorSchedule::findOrFail($id);

        $validated = $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'polyclinic_id' => 'required|exists:polyclinics,id',
            'day' => 'required|string|max:50',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);

        $schedule->update([
            'doctor_id' => $validated['doctor_id'],
            'polyclinic_id' => $validated['polyclinic_id'],
            'day' => $validated['day'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
        ]);

        return back()->with('success', 'Jadwal praktik berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $schedule = DoctorSchedule::findOrFail($id);
        $schedule->delete();
        return back()->with('success', 'Jadwal berhasil dihapus!');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Polyclinic;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminPolyclinicController extends Controller
{
    public function index()
    {
        $polyclinics = Polyclinic::withCount('doctors')->get();
        return view('admin.polyclinics.index', compact('polyclinics'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name_id' => 'required|string|max:255',
            'icon' => 'nullable|string|max:100',
            'description_id' => 'nullable|string',
        ]);

        Polyclinic::create([
            'name' => ['id' => $validated['name_id'], 'en' => $validated['name_id']],
            'slug' => Str::slug($validated['name_id']),
            'description' => ['id' => $validated['description_id'] ?? '', 'en' => $validated['description_id'] ?? ''],
            'icon' => $validated['icon'] ?? 'stethoscope',
            'is_active' => true,
        ]);

        return back()->with('success', 'Poliklinik baru berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $poli = Polyclinic::findOrFail($id);

        $validated = $request->validate([
            'name_id' => 'required|string|max:255',
            'icon' => 'nullable|string|max:100',
            'description_id' => 'nullable|string',
        ]);

        $poli->update([
            'name' => ['id' => $validated['name_id'], 'en' => $validated['name_id']],
            'slug' => Str::slug($validated['name_id']),
            'description' => ['id' => $validated['description_id'] ?? '', 'en' => $validated['description_id'] ?? ''],
            'icon' => $validated['icon'] ?? 'stethoscope',
        ]);

        return back()->with('success', 'Data poliklinik berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $poli = Polyclinic::findOrFail($id);
        $poli->delete();
        return back()->with('success', 'Poliklinik berhasil dihapus!');
    }
}
